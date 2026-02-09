<?php

namespace App\Controller;

use App\Service\SynologyApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/nas')]
class NasController extends AbstractController
{
    public function __construct(
        private readonly SynologyApiService $synologyApi,
    ) {
    }

    /**
     * Main NAS page — shows login or file browser.
     */
    #[Route('', name: 'nas_index')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $sid = $session->get('nas_sid');

        // If we have a SID, verify it's still valid
        if ($sid && !$this->synologyApi->isSessionValid($sid)) {
            $session->remove('nas_sid');
            $session->remove('nas_user');
            $sid = null;
        }

        if (!$sid) {
            return $this->render('portal/nas.html.twig', [
                'connected' => false,
            ]);
        }

        return $this->render('portal/nas.html.twig', [
            'connected' => true,
            'nas_user' => $session->get('nas_user', ''),
        ]);
    }

    /**
     * Login to the NAS.
     */
    #[Route('/login', name: 'nas_login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $account = $request->request->get('nas_account', '');
        $password = $request->request->get('nas_password', '');
        $otpCode = $request->request->get('nas_otp', '');

        if (empty($account) || empty($password)) {
            $this->addFlash('danger', 'nas.error.login_failed');

            return $this->redirectToRoute('nas_index');
        }

        $result = $this->synologyApi->login($account, $password, $otpCode);

        if (!$result['success']) {
            $this->addFlash('danger', 'nas.error.login_failed');

            return $this->redirectToRoute('nas_index');
        }

        $session = $request->getSession();
        $session->set('nas_sid', $result['sid']);
        $session->set('nas_user', $account);

        $this->addFlash('success', 'nas.success.login');

        return $this->redirectToRoute('nas_index');
    }

    /**
     * Logout from the NAS.
     */
    #[Route('/logout', name: 'nas_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $sid = $session->get('nas_sid');

        if ($sid) {
            $this->synologyApi->logout($sid);
        }

        $session->remove('nas_sid');
        $session->remove('nas_user');

        $this->addFlash('success', 'nas.success.logout');

        return $this->redirectToRoute('nas_index');
    }

    /**
     * AJAX — Browse files/folders. Returns JSON.
     */
    #[Route('/browse', name: 'nas_browse', methods: ['GET'])]
    public function browse(Request $request): Response
    {
        $sid = $this->getNasSid($request);
        if (!$sid) {
            return $this->json(['success' => false, 'error' => 'not_authenticated'], 401);
        }

        $path = $request->query->get('path', '');

        if (empty($path)) {
            // List shared folders (root)
            $result = $this->synologyApi->listShares($sid);

            if (!$result['success']) {
                return $this->json(['success' => false, 'error' => 'list_shares_failed']);
            }

            $items = array_map(function ($share) {
                return [
                    'name' => $share['name'],
                    'path' => $share['path'],
                    'isdir' => true,
                    'size' => 0,
                    'time' => $share['additional']['time']['mtime'] ?? 0,
                ];
            }, $result['shares']);

            return $this->json([
                'success' => true,
                'path' => '',
                'parent' => null,
                'items' => $items,
            ]);
        }

        // List folder contents
        $result = $this->synologyApi->listFolder($sid, $path);

        if (!$result['success']) {
            return $this->json(['success' => false, 'error' => 'list_failed', 'error_code' => $result['error_code'] ?? 0]);
        }

        $items = array_map(function ($file) {
            return [
                'name' => $file['name'],
                'path' => $file['path'],
                'isdir' => $file['isdir'],
                'size' => $file['additional']['size'] ?? 0,
                'time' => $file['additional']['time']['mtime'] ?? 0,
            ];
        }, $result['files']);

        // Calculate parent path
        $parent = dirname($path);
        if ($parent === '.' || $parent === $path) {
            $parent = '';
        }

        return $this->json([
            'success' => true,
            'path' => $path,
            'parent' => $parent,
            'items' => $items,
            'total' => $result['total'],
        ]);
    }

    /**
     * Download a file from the NAS.
     */
    #[Route('/download', name: 'nas_download', methods: ['GET'])]
    public function download(Request $request): Response
    {
        $sid = $this->getNasSid($request);
        if (!$sid) {
            $this->addFlash('danger', 'nas.error.session_expired');

            return $this->redirectToRoute('nas_index');
        }

        $path = $request->query->get('path', '');
        if (empty($path)) {
            $this->addFlash('danger', 'nas.error.download_failed');

            return $this->redirectToRoute('nas_index');
        }

        $content = $this->synologyApi->downloadFile($sid, $path);
        if ($content === null) {
            $this->addFlash('danger', 'nas.error.download_failed');

            return $this->redirectToRoute('nas_index');
        }

        $fileName = basename($path);
        $mimeType = $this->guessMimeType($fileName);

        return new StreamedResponse(function () use ($content) {
            echo $content;
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Content-Length' => strlen($content),
        ]);
    }

    /**
     * Upload a file to the NAS.
     */
    #[Route('/upload', name: 'nas_upload', methods: ['POST'])]
    public function upload(Request $request): Response
    {
        $sid = $this->getNasSid($request);
        if (!$sid) {
            return $this->json(['success' => false, 'error' => 'not_authenticated'], 401);
        }

        $destPath = $request->request->get('dest_path', '');
        $uploadedFile = $request->files->get('file');

        if (!$uploadedFile || empty($destPath)) {
            return $this->json(['success' => false, 'error' => 'missing_data']);
        }

        $result = $this->synologyApi->uploadFile(
            $sid,
            $destPath,
            $uploadedFile->getClientOriginalName(),
            file_get_contents($uploadedFile->getPathname()),
            $uploadedFile->getMimeType() ?? 'application/octet-stream',
        );

        return $this->json($result);
    }

    /**
     * AJAX — Get system info. Returns JSON.
     */
    #[Route('/system-info', name: 'nas_system_info', methods: ['GET'])]
    public function systemInfo(Request $request): Response
    {
        $sid = $this->getNasSid($request);
        if (!$sid) {
            return $this->json(['success' => false, 'error' => 'not_authenticated'], 401);
        }

        $sysInfo = $this->synologyApi->getSystemInfo($sid);
        $storageInfo = $this->synologyApi->getStorageInfo($sid);
        $utilization = $this->synologyApi->getUtilization($sid);

        return $this->json([
            'success' => true,
            'system' => $sysInfo['data'] ?? null,
            'storage' => $storageInfo['data'] ?? null,
            'utilization' => $utilization['data'] ?? null,
        ]);
    }

    // ──────────────────────────────────────────────

    private function getNasSid(Request $request): ?string
    {
        return $request->getSession()->get('nas_sid');
    }

    private function guessMimeType(string $fileName): string
    {
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        return match ($ext) {
            'pdf' => 'application/pdf',
            'doc', 'docx' => 'application/msword',
            'xls', 'xlsx' => 'application/vnd.ms-excel',
            'ppt', 'pptx' => 'application/vnd.ms-powerpoint',
            'zip' => 'application/zip',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'mp3' => 'audio/mpeg',
            'mp4' => 'video/mp4',
            'txt' => 'text/plain',
            'csv' => 'text/csv',
            default => 'application/octet-stream',
        };
    }
}
