# Copilot Instructions - Portal IASDCanelas

## Projeto

Portal web para a IASD Canelas, construído com Symfony 7.3, Twig, Doctrine ORM e Bootstrap 5.

## Stack Técnica

- **Backend:** PHP 8.2+, Symfony 7.3
- **Frontend:** Twig, Bootstrap 5 (template Dasher)
- **Base de Dados:** MySQL 8.0, Doctrine ORM
- **Email:** Symfony Mailer (Mailtrap em dev)
- **Traduções:** Symfony Translation (PT/EN)
- **Assets:** Symfony Asset Mapper

## Regras Obrigatórias

### Changelog (OBRIGATÓRIO)

Sempre que uma funcionalidade, correção, melhoria ou alteração significativa for implementada, **é obrigatório adicionar uma entrada no changelog**. Isto deve ser feito de duas formas:

1. **Seed Command** — Adicionar a entrada no array `getChangelogEntries()` em `src/Command/SeedChangelogCommand.php` para futuras instalações limpas.

2. **Estrutura da entrada:**
   ```php
   [
       'version' => 'X.Y.Z',       // Versão semântica
       'title' => 'Título curto',   // Máximo ~60 caracteres
       'description' => '...',       // Descrição detalhada do que foi feito
       'type' => Changelog::TYPE_*,  // feature, bugfix, improvement, security, breaking
       'category' => 'Categoria',    // Ex: Autenticação, UI/UX, Email, i18n, Base de Dados, Infraestrutura
       'author' => 'Simão Soares',   // Autor da alteração
       'date' => 'YYYY-MM-DD',       // Data da implementação
   ]
   ```

3. **Tipos disponíveis:**
   - `TYPE_FEATURE` — Novas funcionalidades
   - `TYPE_BUGFIX` — Correções de bugs
   - `TYPE_IMPROVEMENT` — Melhorias em funcionalidades existentes
   - `TYPE_SECURITY` — Alterações de segurança
   - `TYPE_BREAKING` — Alterações que quebram compatibilidade

### Traduções

- Todas as strings visíveis ao utilizador devem usar o sistema de traduções do Symfony.
- Domínios: `auth` (autenticação), `dashboard`, `messages` (geral/changelog).
- Manter sempre PT e EN sincronizados.

### Convenções de Código

- Controllers em `src/Controller/`, um ficheiro por controller.
- Entidades em `src/Entity/` com atributos Doctrine ORM.
- Repositórios em `src/Repository/`.
- Forms em `src/Form/`.
- Services em `src/Service/`.
- Commands em `src/Command/`.
- Templates seguem a estrutura existente e estendem `base.html.twig`.
- Templates de autenticação em `templates/pages/authentication/`.
- Templates de email em `templates/emails/`.

### Segurança

- Páginas públicas: `/login`, `/register`, `/forgot-password`, `/reset-password`, `/changelog`, `/pages/auth/*`, `/pages/error/*`.
- Todas as outras páginas requerem `ROLE_USER`.
- CSRF protection ativo em formulários de login e forms Symfony.

### Base de Dados

- Criar migration para cada alteração de schema.
- Ficheiros de migration em `migrations/`.
- Nomear migrations com timestamp: `VersionYYYYMMDDHHMMSS.php`.
