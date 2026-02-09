# Copilot Instructions - Portal IASDCanelas

## Projeto

Portal web interno para a **Igreja Adventista do Sétimo Dia de Canelas** (IASD Canelas).
O objetivo é fornecer aos membros uma plataforma centralizada para gestão de escalas de serviço, transmissões, documentos, calendário e comunicação interna.

Construído com Symfony 7.3, Twig, Doctrine ORM e Bootstrap 5 (template Dasher).

## Stack Técnica

- **Backend:** PHP 8.2+, Symfony 7.3
- **Frontend:** Twig, Bootstrap 5 (template Dasher), Tabler Icons (SVG inline)
- **Base de Dados:** MySQL 8.0, Doctrine ORM
- **Email:** Symfony Mailer (Mailtrap em dev, sincróno)
- **Traduções:** Symfony Translation (PT/EN)
- **Assets:** Symfony Asset Mapper
- **CSS:** `public/css/theme.css` com variáveis CSS `--ds-*`, cor primária `#2E86C1` (azul)

## Estrutura de Navegação

### Sidebar (zona principal)
- **Dashboard** — Painel principal com resumo de cultos, escalas, transmissões e avisos
- **Escalas Pessoais** — Tabela com escalas do utilizador (data, culto, departamento, função, estado)
- **Transmissão** — Dashboard para equipa de transmissão (próximas transmissões, checklist técnica)
- **Documentos/Recursos** — Lista de documentos partilhados com pesquisa e filtro
- **Ajuda/Contactos** — Cards de contacto e FAQ

### Zonas futuras (não implementadas ainda)
- Calendário de eventos
- Gestão de membros (admin)
- Configurações de perfil

## Regras Obrigatórias

### Traduções

- Todas as strings visíveis ao utilizador devem usar o sistema de traduções do Symfony.
- Domínios: `auth` (autenticação), `dashboard` (painel/escalas/transmissão), `messages` (geral/comum).
- Manter sempre PT e EN sincronizados.
- Usar `|trans({}, 'dominio')` nos templates Twig.

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
- Novos ecrãs seguem o padrão: `{% extends 'base.html.twig' %}` → includes `sidebar-collapse.html.twig` + `topbar-second.html.twig` → conteúdo em `div.custom-container`.

### Padrão de Template

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

### Segurança

- Páginas públicas: `/login`, `/register`, `/forgot-password`, `/reset-password`, `/pages/auth/*`, `/pages/error/*`.
- Todas as outras páginas requerem `ROLE_USER`.
- CSRF protection ativo em formulários de login e forms Symfony.

### Base de Dados

- Criar migration para cada alteração de schema.
- Ficheiros de migration em `migrations/`.
- Nomear migrations com timestamp: `VersionYYYYMMDDHHMMSS.php`.
