# Copilot Instructions - Portal IASDCanelas

## Projeto

Portal web interno para a **Igreja Adventista do Sétimo Dia de Canelas** (IASD Canelas).
O objetivo é fornecer aos membros uma plataforma centralizada para gestão de escalas de serviço, transmissões, documentos, calendário, comunicação interna e acesso a ficheiros no NAS Synology.

Construído com Symfony 7.3, Twig, Doctrine ORM e Bootstrap 5 (template Dasher).

## Stack Técnica

- **Backend:** PHP 8.2+, Symfony 7.3
- **Frontend:** Twig, Bootstrap 5 (template Dasher), Tabler Icons (SVG inline)
- **Base de Dados:** MySQL 8.0 (`192.168.1.167`), Doctrine ORM
- **Email:** Symfony Mailer (Mailtrap sandbox em dev, síncrono). Service: `MailerService` com logging automático.
- **Traduções:** Symfony Translation (PT/EN), 3 domínios: `auth`, `dashboard`, `messages`
- **Assets:** Symfony Asset Mapper + `public/css/theme.css` + `public/js/main.js`
- **CSS:** `public/css/theme.css` com variáveis CSS `--ds-*`, cor primária `#2E86C1` (azul)
- **NAS:** Integração com Synology DSM via HTTP API (QuickConnect + relay tunnel). Service: `SynologyApiService`.
- **Cache:** Symfony `CacheInterface` (`cache.app`) — usado para cachear URL resolvida do NAS (30 min).

## Arquitetura de Ficheiros

```
src/
  Controller/     — Um controller por funcionalidade
    AuthController.php        — Login, register, forgot/reset password
    DashboardController.php   — Página principal (/ → /dashboard)
    EscalasController.php     — Escalas pessoais (/escalas)
    TransmissaoController.php — Transmissão (/transmissao)
    DocumentosController.php  — Documentos (/documentos)
    NasController.php         — NAS Synology (/nas, /nas/login, /nas/browse, etc.)
    AjudaController.php       — Ajuda/Contactos (/ajuda)
    AppsController.php        — Demo pages do Dasher (não portal)
    ComponentsController.php  — Demo components do Dasher (não portal)
    PagesController.php       — Páginas de erro + redirects auth
  Entity/
    User.php                  — Utilizador (email, fullName, roles, password, isVerified, resetToken)
    EmailLog.php              — Log de emails enviados (recipientEmail, subject, type, status)
  Repository/
    UserRepository.php        — upgradePassword(), findByResetToken()
    EmailLogRepository.php    — findAllOrderedByDate(), findByStatus(), findByRecipient()
  Form/
    RegistrationFormType.php  — fullName, email, plainPassword (repeated, min 8), agreeTerms
    ForgotPasswordFormType.php — email
    ResetPasswordFormType.php — plainPassword (repeated, min 8)
  Service/
    MailerService.php         — sendResetPasswordEmail(), sendAndLog() com EmailLog automático
    SynologyApiService.php    — API client Synology DSM (QuickConnect, FileStation, sistema)
templates/
  base.html.twig              — Layout raiz (blocks: title, body, stylesheets, javascripts)
  portal/                     — Páginas do portal (dashboard, escalas, transmissao, documentos, nas, ajuda)
  pages/authentication/       — Auth templates (sign-in, sign-up, forget-password, reset-password, otp)
  pages/error/                — 404, maintenance
  emails/                     — Templates de email (reset-password.html.twig)
  partials/                   — Fragmentos reutilizáveis (sidebar-collapse, topbar-second, scripts, head/*)
translations/
  auth.pt.yaml / auth.en.yaml           — Domínio auth (login, register, forgot/reset password, OTP)
  dashboard.pt.yaml / dashboard.en.yaml — Domínio dashboard (sidebar, dashboard, escalas, transmissao, documentos, ajuda, NAS)
  messages.pt.yaml / messages.en.yaml   — Domínio messages (common actions: view, edit, delete, save, etc.)
```

## Estrutura de Navegação (Sidebar)

| Ícone Tabler | Label (chave) | Rota | Controller |
|---|---|---|---|
| `icon-tabler-layout-dashboard` | `sidebar.dashboard` | `dashboard_index` | DashboardController |
| `icon-tabler-calendar-event` | `sidebar.schedules` | `escalas_index` | EscalasController |
| `icon-tabler-broadcast` | `sidebar.broadcast` | `transmissao_index` | TransmissaoController |
| `icon-tabler-folder` | `sidebar.documents` | `documentos_index` | DocumentosController |
| `icon-tabler-server` | `sidebar.nas` | `nas_index` | NasController |
| `icon-tabler-help` | `sidebar.help` | `ajuda_index` | AjudaController |

Sidebar definida em `templates/partials/sidebar-collapse.html.twig` — desktop + mobile offcanvas (duplicados, manter sincronizados).
Logo: `images/brand/logo/portal.png`.

### Zonas futuras (não implementadas ainda)
- Calendário de eventos
- Gestão de membros (admin)
- Configurações de perfil
- Envio de emails de boas-vindas, notificações

## Entidades e Relações

### User
- **Tabela:** `user`
- **Campos:** `id`, `email` (unique), `fullName`, `roles` (json, default `ROLE_USER`), `password` (hashed), `isVerified` (default false), `resetToken` (nullable), `resetTokenExpiresAt` (nullable), `createdAt`, `updatedAt` (`@PreUpdate`)
- **Método útil:** `isResetTokenValid()` — verifica se token não expirou.

### EmailLog
- **Tabela:** `email_log`
- **Campos:** `id`, `recipientEmail` (indexed), `recipientName`, `subject`, `type` (indexed — `reset_password`, `welcome`, `notification`, `other`), `status` (indexed — `sent`, `failed`), `errorMessage`, `sentAt`
- **Relação:** `ManyToOne` → `User` (nullable, `SET NULL` on delete)

## Services

### MailerService
- `sendResetPasswordEmail(User)` — envia email com link de reset, usa template `emails/reset-password.html.twig`
- `sendAndLog(...)` — método privado que envia email e grava `EmailLog` automaticamente (success ou failure)
- Remetente: `noreply@portal-iasdcanelas.pt` / `Portal IASDCanelas`

### SynologyApiService
- **Resolução QuickConnect:** `global.quickconnect.to/Serv.php` → `get_server_info` → control host → `request_tunnel` → relay HTTP URL
- **Método que funciona:** HTTP relay via `relay_dn:relay_port` (ex: `http://synr-fr1.CLOUD-IASDCANELAS.direct.quickconnect.to:PORT`). O porto é dinâmico.
- **Cache:** URL resolvida cacheada 30 min via `CacheInterface` (chave: `synology_resolved_url`). Failover cached 1 min.
- **LAN não funciona:** A NAS está em `192.168.1.64` mas portas 5000/5001 não são acessíveis do servidor do portal. External IP (`144.64.117.30`) também não tem port forwarding. DDNS/FQDN estão `NULL`.
- **HTTPS relay não funciona:** SSL version mismatch no relay tunnel. Apenas HTTP relay funciona.
- **Login:** POST para `SYNO.API.Auth` v7, suporta OTP via campo `otp_code`. Session ID (`sid`) guardado em sessão PHP (`nas_sid`, `nas_user`).
- **Métodos públicos:** `login()`, `logout()`, `listShares()`, `listFolder()`, `downloadFile()`, `uploadFile()`, `getSystemInfo()`, `getStorageInfo()`, `getUtilization()`, `isSessionValid()`, `invalidateResolvedUrl()`
- **Invalidação:** Chamar `invalidateResolvedUrl()` quando a conexão falha para forçar re-resolução.

## Regras Obrigatórias

### Traduções

- Todas as strings visíveis ao utilizador devem usar o sistema de traduções do Symfony.
- Domínios: `auth` (autenticação), `dashboard` (painel/escalas/transmissão/documentos/NAS/ajuda), `messages` (ações comuns: view, edit, delete, etc.).
- Manter sempre **PT e EN sincronizados** — ao adicionar uma chave num ficheiro, adicionar no outro.
- Usar `|trans({}, 'dominio')` nos templates Twig.
- Flash messages: usar chaves de tradução (ex: `nas.success.login`), não texto direto.
- Chaves de tradução usam notação dot: `section.subsection.key` (ex: `nas.login.title`).

### Convenções de Código

- Controllers em `src/Controller/`, um ficheiro por controller.
- Entidades em `src/Entity/` com atributos Doctrine ORM (`#[ORM\Column]`, `#[ORM\Entity]`, etc.).
- Repositórios em `src/Repository/`.
- Forms em `src/Form/`, com `'translation_domain'` definido nas options.
- Services em `src/Service/`, injetados via autowiring.
- Commands em `src/Command/`.
- Templates do portal em `templates/portal/`, estendem `base.html.twig`.
- Templates de autenticação em `templates/pages/authentication/`.
- Templates de email em `templates/emails/`.
- Bindings de parâmetros em `config/services.yaml` sob `_defaults.bind`.

### Padrão de Template (Portal)

```twig
{% extends 'base.html.twig' %}
{% block title %}Título | Portal IASDCanelas{% endblock %}
{% block body %}
    <div>
      {% include 'partials/sidebar-collapse.html.twig' %}
      <div id="content" class="position-relative h-100">
        {% include 'partials/topbar-second.html.twig' %}
        <div class="custom-container">
          {# Conteúdo aqui #}
        </div>
      </div>
    </div>
{% endblock %}
```

### Padrão de Cards

- Usar classes: `card card-lg`, `card-body d-flex flex-column gap-8`
- Gradientes: `bg-gradient-primary`, `bg-gradient-info`, `bg-gradient-warning`, `bg-gradient-danger`, `bg-gradient-success`
- Ícones: Tabler Icons em SVG inline (20x20 ou 24x24, stroke-width 1.5)
- Grid: `row g-6 mb-6`, colunas `col-xl-3 col-md-6 col-12`

### Padrão de Tabelas

- Wrapper: `card` → `card-body` → `div.table-responsive`
- Classe da tabela: `table text-nowrap mb-0 table-centered table-hover`
- Badges de estado: `badge text-{color}-emphasis bg-{color}-subtle rounded-2`
- Cores de badge: `success` (confirmado/concluído), `warning` (pendente), `danger` (cancelado/erro), `info` (em preparação), `primary` (ativo)

### Segurança

- **Firewall:** `main` com `form_login` (CSRF ativo), `remember_me` (1 semana), `logout`.
- **Provider:** Entity `User`, login por `email`.
- **Páginas públicas:** `/login`, `/register`, `/forgot-password`, `/reset-password`, `/pages/auth/*`, `/pages/error/*`.
- **Todas as outras páginas** requerem `ROLE_USER`.
- **CSRF protection** ativo em formulários de login e forms Symfony.
- **NAS:** Sessão Synology separada — `nas_sid` e `nas_user` guardados na sessão PHP. Não é ROLE-based, qualquer `ROLE_USER` pode aceder ao NAS se tiver credenciais Synology.

### Base de Dados

- Criar migration para cada alteração de schema.
- Ficheiros de migration em `migrations/`.
- Nomear migrations com timestamp: `VersionYYYYMMDDHHMMSS.php`.
- `messenger_messages` table: configurada com `auto_setup=0` — criar manualmente se necessário.

### JavaScript

- `public/js/main.js` — inicializações globais (OTP, checkboxes, alerts, popovers, tooltips, form validation, toasts, sidebar nav, global search).
- `public/js/vendors/sidebarnav.js` — incluído globalmente em `scripts.html.twig` para sidebar toggle funcionar.
- JS específico de página: inline no template dentro de `{% block javascripts %}` (ex: NAS file browser).
- AJAX requests: usar `fetch()` nativo com headers `X-Requested-With: XMLHttpRequest`.

### Variáveis de Ambiente

| Variável | Descrição | Exemplo |
|---|---|---|
| `APP_ENV` | Ambiente | `dev` |
| `APP_SECRET` | Secret key | hash |
| `DATABASE_URL` | Conexão MySQL | `mysql://user:pass@host:3306/db?serverVersion=8.0` |
| `MAILER_DSN` | Transporte email | `smtp://...@sandbox.smtp.mailtrap.io:587` |
| `SYNOLOGY_NAS_URL` | URL base do NAS (QuickConnect) | `https://cloud-iasdcanelas.quickconnect.to/` |

### Topbar

- Definida em `templates/partials/topbar-second.html.twig` (~990 linhas).
- Inclui: search modal (global), notificações, dropdown do utilizador (nome, email, logout).
- Dropdown do utilizador mostra `app.user.fullName` e `app.user.email`.
- Search modal: referência à rota `dashboard_index` (não `dashboard_analytics`).

### Flash Messages

- Usar `app.flashes()` no Twig para exibir mensagens.
- Tipos: `success`, `danger`, `warning`, `info`.
- Texto das flash messages: sempre chaves de tradução, não texto hardcoded.
- Padrão: `{secção}.{estado}.{ação}` (ex: `nas.success.login`, `nas.error.login_failed`).

## Lições Aprendidas / Gotchas

1. **QuickConnect não é uma API direta** — o URL `*.quickconnect.to` retorna uma página HTML redirect, não um endpoint API. É necessário resolver via protocolo QuickConnect (`global.quickconnect.to/Serv.php` → control host → `request_tunnel`).
2. **Relay tunnel é o único método funcional** para este NAS. LAN, DDNS, external IP e HTTPS relay não funcionam. Sempre tentar HTTP relay (`relay_dn:relay_port`) primeiro e sem `testConnection()` (para evitar latência extra).
3. **O porto do relay é dinâmico** — muda periodicamente, por isso não pode ser hardcoded. Cachear a URL resolvida por 30 min é o equilíbrio certo.
4. **Synology API Auth usa POST** (não GET) para login — enviar password no query string é rejeitado.
5. **`messenger_messages` table** — com `auto_setup=0` no messenger transport, a tabela não é criada automaticamente. Criar via migration se necessário.
6. **Sidebar collapse/expand** requer `sidebarnav.js` incluído globalmente em `scripts.html.twig`.
7. **Campos Synology `ddns` e `fqdn`** podem retornar a string literal `"NULL"` em vez de null — verificar com `!== 'NULL'`.
8. **Cache Symfony** — `$this->resolvedUrl` é uma propriedade de instância que reseta a cada request (services não são singleton por defeito). O `CacheInterface` (`cache.app`) persiste entre requests. Invalidar com `cache->delete('key')`.
9. **Traduções** — os domínios de tradução estão nos ficheiros YAML em `translations/`. Ao adicionar novas secções, adicionar em **ambos** `*.pt.yaml` e `*.en.yaml`. Flash messages no controller devem usar as mesmas chaves que existem nos YAMLs.
10. **Topbar search modal** — usa rota `dashboard_index`, não `dashboard_analytics` (que não existe).
