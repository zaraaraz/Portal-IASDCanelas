<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SynologyApiService
{
    private string $baseUrl;
    private ?string $resolvedUrl = null;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger,
        private readonly CacheInterface $cache,
        string $synologyNasUrl,
    ) {
        $this->baseUrl = rtrim($synologyNasUrl, '/');
    }

    /**
     * Get the actual API base URL, resolving QuickConnect if needed.
     * Result is cached for 30 minutes to avoid re-resolving on every request.
     */
    private function getApiBaseUrl(): string
    {
        if ($this->resolvedUrl !== null) {
            return $this->resolvedUrl;
        }

        // Check if it's a QuickConnect URL
        if (preg_match('/^https?:\/\/([^.]+)\.quickconnect\.to/i', $this->baseUrl, $matches)) {
            $serverId = $matches[1];

            $this->resolvedUrl = $this->cache->get('synology_resolved_url', function (ItemInterface $item) use ($serverId) {
                $item->expiresAfter(1800); // Cache for 30 minutes

                $this->logger->info('Cache MISS — resolving QuickConnect', ['serverId' => $serverId]);
                $resolved = $this->resolveQuickConnect($serverId);
                if ($resolved) {
                    $this->logger->info('QuickConnect resolved and cached for 30 min', ['serverId' => $serverId, 'url' => $resolved]);

                    return $resolved;
                }

                $this->logger->warning('QuickConnect resolution failed, falling back to raw URL');
                $item->expiresAfter(60); // Only cache failure for 1 minute

                return $this->baseUrl;
            });

            $this->logger->debug('Using NAS URL (from cache or resolve)', ['url' => $this->resolvedUrl]);

            return $this->resolvedUrl;
        }

        $this->resolvedUrl = $this->baseUrl;

        return $this->resolvedUrl;
    }

    /**
     * Invalidate the cached resolved URL (e.g. when connection fails).
     */
    public function invalidateResolvedUrl(): void
    {
        $this->resolvedUrl = null;
        $this->cache->delete('synology_resolved_url');
    }

    /**
     * Resolve a QuickConnect server ID to an actual DSM URL.
     */
    private function resolveQuickConnect(string $serverId): ?string
    {
        try {
            // Step 1: Query global relay for server info
            $response = $this->httpClient->request('POST', 'https://global.quickconnect.to/Serv.php', [
                'json' => [
                    'version' => 1,
                    'command' => 'get_server_info',
                    'stop_when_error' => false,
                    'stop_when_success' => false,
                    'id' => 'dsm',
                    'serverID' => $serverId,
                ],
                'timeout' => 15,
            ]);

            $data = $response->toArray(false);
            $this->logger->debug('QuickConnect server info', ['data' => json_encode($data)]);

            if (($data['errno'] ?? -1) !== 0) {
                return null;
            }

            $server = $data['server'] ?? [];
            $service = $data['service'] ?? [];
            $smartdns = $data['smartdns'] ?? [];
            $httpPort = $service['port'] ?? 5000;
            $httpsPort = ($service['ext_port'] ?? 0) > 0 ? $service['ext_port'] : 5001;

            // Helper: test both HTTPS and HTTP for a given host
            $tryHost = function (string $host) use ($httpsPort, $httpPort): ?string {
                $httpsUrl = 'https://' . $host . ':' . $httpsPort;
                if ($this->testConnection($httpsUrl)) {
                    return $httpsUrl;
                }
                $httpUrl = 'http://' . $host . ':' . $httpPort;
                if ($this->testConnection($httpUrl)) {
                    return $httpUrl;
                }

                return null;
            };

            // Try 1: Relay tunnel (most reliable for QuickConnect without port forwarding)
            $controlHost = $data['env']['control_host'] ?? null;
            if ($controlHost) {
                $tunnelUrl = $this->requestRelayTunnel($controlHost, $serverId, $service);
                if ($tunnelUrl) {
                    return $tunnelUrl;
                }
            }

            // Try 2: LAN IPs (only if relay failed — usually unreachable from external)
            $interfaces = $server['interface'] ?? [];
            foreach ($interfaces as $iface) {
                if (!empty($iface['ip']) && $iface['ip'] !== '0.0.0.0') {
                    $result = $tryHost($iface['ip']);
                    if ($result) {
                        return $result;
                    }
                }
            }

            return null;
        } catch (\Throwable $e) {
            $this->logger->error('QuickConnect resolution error', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * Test if a DSM URL is reachable by hitting the API info endpoint.
     */
    private function testConnection(string $url): bool
    {
        try {
            $response = $this->httpClient->request('GET', $url . '/webapi/query.cgi', [
                'query' => [
                    'api' => 'SYNO.API.Info',
                    'version' => 1,
                    'method' => 'query',
                    'query' => 'SYNO.API.Auth',
                ],
                'verify_peer' => false,
                'verify_host' => false,
                'timeout' => 3,
            ]);

            $content = $response->getContent(false);
            $data = json_decode($content, true);

            $success = ($data['success'] ?? false) === true;
            $this->logger->debug('Connection test', ['url' => $url, 'success' => $success]);

            return $success;
        } catch (\Throwable $e) {
            $this->logger->debug('Connection test failed', ['url' => $url, 'error' => $e->getMessage()]);

            return false;
        }
    }

    /**
     * Request a relay tunnel through QuickConnect control host.
     */
    private function requestRelayTunnel(string $controlHost, string $serverId, array $service): ?string
    {
        try {
            $response = $this->httpClient->request('POST', 'https://' . $controlHost . '/Serv.php', [
                'json' => [
                    'version' => 1,
                    'command' => 'request_tunnel',
                    'stop_when_error' => false,
                    'stop_when_success' => false,
                    'id' => 'dsm',
                    'serverID' => $serverId,
                ],
                'timeout' => 15,
            ]);

            $data = $response->toArray(false);
            $this->logger->debug('QuickConnect tunnel response', ['data' => json_encode($data)]);

            if (($data['errno'] ?? -1) === 0) {
                $svc = $data['service'] ?? [];

                // Try 1: HTTP relay (relay_dn + relay_port) — fastest and most reliable
                // Skip testConnection() as this method consistently works
                $relayDn = $svc['relay_dn'] ?? '';
                $relayPort = $svc['relay_port'] ?? 0;
                if (!empty($relayDn) && $relayPort > 0) {
                    $httpUrl = 'http://' . $relayDn . ':' . $relayPort;
                    $this->logger->info('Relay tunnel resolved (HTTP)', ['url' => $httpUrl]);

                    return $httpUrl;
                }

                // Try 2: HTTPS relay (https_ip + https_port) — fallback
                $httpsIp = $svc['https_ip'] ?? '';
                $httpsPort = $svc['https_port'] ?? 0;
                if (!empty($httpsIp) && $httpsPort > 0) {
                    $httpsUrl = 'https://' . $httpsIp . ':' . $httpsPort;
                    if ($this->testConnection($httpsUrl)) {
                        return $httpsUrl;
                    }
                }
            }

            return null;
        } catch (\Throwable $e) {
            $this->logger->debug('Relay tunnel request failed', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * Login to Synology DSM and return the session ID (SID).
     */
    public function login(string $account, string $password, string $otpCode = ''): array
    {
        $params = [
            'method' => 'login',
            'version' => 7,
            'account' => $account,
            'passwd' => $password,
            'session' => 'FileStation',
            'format' => 'sid',
        ];

        if (!empty($otpCode)) {
            $params['otp_code'] = $otpCode;
            $params['enable_device_token'] = 'no';
        }

        $response = $this->request('SYNO.API.Auth', 'auth.cgi', $params, 'POST');

        if (!$response['success']) {
            $errorCode = $response['error']['code'] ?? 0;
            $this->logger->warning('Synology login failed', ['error_code' => $errorCode]);

            return ['success' => false, 'error_code' => $errorCode];
        }

        return ['success' => true, 'sid' => $response['data']['sid']];
    }

    /**
     * Logout from Synology DSM.
     */
    public function logout(string $sid): void
    {
        try {
            $this->request('SYNO.API.Auth', 'auth.cgi', [
                'method' => 'logout',
                'version' => 7,
                'session' => 'FileStation',
                '_sid' => $sid,
            ]);
        } catch (\Throwable $e) {
            $this->logger->warning('Synology logout failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * List shared folders.
     */
    public function listShares(string $sid): array
    {
        $response = $this->request('SYNO.FileStation.List', 'entry.cgi', [
            'method' => 'list_share',
            'version' => 2,
            'additional' => '["size","time"]',
            '_sid' => $sid,
        ]);

        if (!$response['success']) {
            return ['success' => false, 'shares' => []];
        }

        return ['success' => true, 'shares' => $response['data']['shares'] ?? []];
    }

    /**
     * List files and folders inside a given path.
     */
    public function listFolder(string $sid, string $folderPath): array
    {
        $response = $this->request('SYNO.FileStation.List', 'entry.cgi', [
            'method' => 'list',
            'version' => 2,
            'folder_path' => $folderPath,
            'additional' => '["size","time","type"]',
            'sort_by' => 'name',
            'sort_direction' => 'asc',
            '_sid' => $sid,
        ]);

        if (!$response['success']) {
            $errorCode = $response['error']['code'] ?? 0;

            return ['success' => false, 'files' => [], 'error_code' => $errorCode];
        }

        return [
            'success' => true,
            'files' => $response['data']['files'] ?? [],
            'total' => $response['data']['total'] ?? 0,
            'offset' => $response['data']['offset'] ?? 0,
        ];
    }

    /**
     * Get a download URL/stream for a file.
     * Returns the raw response content for streaming.
     */
    public function downloadFile(string $sid, string $path): ?string
    {
        $url = $this->baseUrl . '/webapi/entry.cgi?' . http_build_query([
            'api' => 'SYNO.FileStation.Download',
            'version' => 2,
            'method' => 'download',
            'path' => $path,
            'mode' => 'download',
            '_sid' => $sid,
        ]);

        try {
            $response = $this->httpClient->request('GET', $url, [
                'verify_peer' => false,
                'verify_host' => false,
                'timeout' => 120,
            ]);

            return $response->getContent();
        } catch (\Throwable $e) {
            $this->logger->error('Synology download failed', ['error' => $e->getMessage(), 'path' => $path]);

            return null;
        }
    }

    /**
     * Upload a file to the NAS.
     */
    public function uploadFile(string $sid, string $destFolderPath, string $fileName, string $fileContent, string $mimeType): array
    {
        $url = $this->baseUrl . '/webapi/entry.cgi';

        try {
            $boundary = bin2hex(random_bytes(16));
            $body = $this->buildMultipartBody($boundary, [
                'api' => 'SYNO.FileStation.Upload',
                'version' => 2,
                'method' => 'upload',
                'path' => $destFolderPath,
                'create_parents' => 'true',
                'overwrite' => 'true',
                '_sid' => $sid,
            ], $fileName, $fileContent, $mimeType);

            $response = $this->httpClient->request('POST', $url, [
                'verify_peer' => false,
                'verify_host' => false,
                'timeout' => 300,
                'headers' => [
                    'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
                ],
                'body' => $body,
            ]);

            $data = $response->toArray(false);

            if (!($data['success'] ?? false)) {
                return ['success' => false, 'error_code' => $data['error']['code'] ?? 0];
            }

            return ['success' => true];
        } catch (\Throwable $e) {
            $this->logger->error('Synology upload failed', ['error' => $e->getMessage()]);

            return ['success' => false, 'error_code' => -1];
        }
    }

    /**
     * Get DSM system information.
     */
    public function getSystemInfo(string $sid): array
    {
        $response = $this->request('SYNO.DSM.Info', 'entry.cgi', [
            'method' => 'getinfo',
            'version' => 2,
            '_sid' => $sid,
        ]);

        if (!$response['success']) {
            return ['success' => false];
        }

        return ['success' => true, 'data' => $response['data']];
    }

    /**
     * Get storage/volume information.
     */
    public function getStorageInfo(string $sid): array
    {
        $response = $this->request('SYNO.Storage.CGI.Storage', 'entry.cgi', [
            'method' => 'load_info',
            'version' => 1,
            '_sid' => $sid,
        ]);

        if (!$response['success']) {
            return ['success' => false];
        }

        return ['success' => true, 'data' => $response['data']];
    }

    /**
     * Get system utilization (CPU, RAM, etc.).
     */
    public function getUtilization(string $sid): array
    {
        $response = $this->request('SYNO.Core.System.Utilization', 'entry.cgi', [
            'method' => 'get',
            'version' => 1,
            '_sid' => $sid,
        ]);

        if (!$response['success']) {
            return ['success' => false];
        }

        return ['success' => true, 'data' => $response['data']];
    }

    /**
     * Check if a SID is still valid.
     */
    public function isSessionValid(string $sid): bool
    {
        $result = $this->getSystemInfo($sid);

        return $result['success'];
    }

    // ──────────────────────────────────────────────
    // Private helpers
    // ──────────────────────────────────────────────

    private function request(string $api, string $cgiPath, array $params, string $method = 'GET'): array
    {
        $params['api'] = $api;
        $url = $this->getApiBaseUrl() . '/webapi/' . $cgiPath;

        try {
            $options = [
                'verify_peer' => false,
                'verify_host' => false,
                'timeout' => 30,
            ];

            if ($method === 'POST') {
                $options['body'] = $params;
            } else {
                $options['query'] = $params;
            }

            $response = $this->httpClient->request($method, $url, $options);

            $content = $response->getContent(false);
            $this->logger->debug('Synology API raw response', [
                'api' => $api,
                'status' => $response->getStatusCode(),
                'body' => substr($content, 0, 500),
            ]);

            $decoded = json_decode($content, true);
            if ($decoded === null) {
                $this->logger->error('Synology API returned non-JSON response', [
                    'api' => $api,
                    'body' => substr($content, 0, 500),
                ]);

                return ['success' => false, 'error' => ['code' => -1]];
            }

            return $decoded;
        } catch (\Throwable $e) {
            $this->logger->error('Synology API request failed', [
                'api' => $api,
                'error' => $e->getMessage(),
            ]);

            return ['success' => false, 'error' => ['code' => -1]];
        }
    }

    private function buildMultipartBody(string $boundary, array $fields, string $fileName, string $fileContent, string $mimeType): string
    {
        $body = '';

        foreach ($fields as $name => $value) {
            $body .= "--{$boundary}\r\n";
            $body .= "Content-Disposition: form-data; name=\"{$name}\"\r\n\r\n";
            $body .= "{$value}\r\n";
        }

        $body .= "--{$boundary}\r\n";
        $body .= "Content-Disposition: form-data; name=\"file\"; filename=\"{$fileName}\"\r\n";
        $body .= "Content-Type: {$mimeType}\r\n\r\n";
        $body .= $fileContent . "\r\n";
        $body .= "--{$boundary}--\r\n";

        return $body;
    }
}
