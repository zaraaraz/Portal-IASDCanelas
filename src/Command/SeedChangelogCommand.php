<?php

namespace App\Command;

use App\Entity\Changelog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:seed-changelog',
    description: 'Seed the changelog with initial entries',
)]
class SeedChangelogCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $entries = $this->getChangelogEntries();

        foreach ($entries as $entryData) {
            $entry = new Changelog();
            $entry->setVersion($entryData['version']);
            $entry->setTitle($entryData['title']);
            $entry->setDescription($entryData['description']);
            $entry->setType($entryData['type']);
            $entry->setCategory($entryData['category'] ?? null);
            $entry->setAuthor($entryData['author'] ?? null);
            $entry->setDate(new \DateTimeImmutable($entryData['date']));

            $this->entityManager->persist($entry);
        }

        $this->entityManager->flush();

        $io->success(sprintf('Successfully seeded %d changelog entries.', count($entries)));

        return Command::SUCCESS;
    }

    private function getChangelogEntries(): array
    {
        return [
            // v0.1.0 - Estrutura Base do Projeto
            [
                'version' => '0.1.0',
                'title' => 'Estrutura inicial do projeto Symfony',
                'description' => 'Criação do projeto base com Symfony 7.3, configuração do Doctrine ORM, Twig, Asset Mapper e todas as dependências necessárias.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'Infraestrutura',
                'author' => 'Simão Soares',
                'date' => '2026-01-15',
            ],
            [
                'version' => '0.1.0',
                'title' => 'Template Dashboard integrado',
                'description' => 'Integração do template Dasher Bootstrap 5 com múltiplas páginas de dashboard: Project, Analytics, Ecommerce, CRM, Finance, Blog e File Manager.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'UI/UX',
                'author' => 'Simão Soares',
                'date' => '2026-01-15',
            ],
            [
                'version' => '0.1.0',
                'title' => 'Sistema de navegação com sidebar',
                'description' => 'Implementação do sidebar colapsável com navegação completa, incluindo versão mobile com offcanvas.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'UI/UX',
                'author' => 'Simão Soares',
                'date' => '2026-01-15',
            ],
            [
                'version' => '0.1.0',
                'title' => 'Sistema de traduções (PT/EN)',
                'description' => 'Configuração do sistema de internacionalização com ficheiros de tradução para Português e Inglês.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'i18n',
                'author' => 'Simão Soares',
                'date' => '2026-01-15',
            ],
            [
                'version' => '0.1.0',
                'title' => 'Páginas de componentes',
                'description' => 'Páginas de demonstração de todos os componentes Bootstrap 5: Accordions, Alerts, Avatar, Badges, Breadcrumbs, Buttons, Cards, Carousel, etc.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'UI/UX',
                'author' => 'Simão Soares',
                'date' => '2026-01-15',
            ],

            // v0.2.0 - Autenticação
            [
                'version' => '0.2.0',
                'title' => 'Entidade User com Doctrine ORM',
                'description' => 'Criação da entidade User com campos: email, fullName, password, roles, isVerified, resetToken, resetTokenExpiresAt, createdAt e updatedAt. Implementa UserInterface e PasswordAuthenticatedUserInterface.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'Autenticação',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
            [
                'version' => '0.2.0',
                'title' => 'Sistema de Login com Symfony Security',
                'description' => 'Implementação do form_login com CSRF protection, remember me cookie (1 semana), e redirecionamento automático após login. Configuração completa do security.yaml com firewalls e access control.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'Autenticação',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
            [
                'version' => '0.2.0',
                'title' => 'Registo de utilizadores',
                'description' => 'Formulário de registo com validação completa: nome, email único, password com confirmação (mínimo 8 caracteres), e aceitação dos termos de uso. Password hashing automático.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'Autenticação',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
            [
                'version' => '0.2.0',
                'title' => 'Recuperação de palavra-passe',
                'description' => 'Sistema de forgot/reset password com token seguro (64 caracteres hex), expiração de 1 hora. Formulário de pedido de recuperação e formulário de redefinição de password.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'Autenticação',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
            [
                'version' => '0.2.0',
                'title' => 'Controlo de acesso (Access Control)',
                'description' => 'Configuração de access control: páginas públicas (/login, /register, /forgot-password, /reset-password, /changelog) e páginas protegidas que requerem ROLE_USER.',
                'type' => Changelog::TYPE_SECURITY,
                'category' => 'Autenticação',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
            [
                'version' => '0.2.0',
                'title' => 'Templates de autenticação atualizados',
                'description' => 'Atualização dos templates sign-in, sign-up, forget-password, reset-password e OTP verification para usar formulários Symfony reais com CSRF, flash messages e validação server-side.',
                'type' => Changelog::TYPE_IMPROVEMENT,
                'category' => 'UI/UX',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
            [
                'version' => '0.2.0',
                'title' => 'Traduções de autenticação (PT/EN)',
                'description' => 'Adição de todas as traduções necessárias para as páginas de autenticação: sign-in, register, forgot-password, reset-password e OTP, em Português e Inglês.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'i18n',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],

            // v0.2.0 - Changelog
            [
                'version' => '0.2.0',
                'title' => 'Sistema de Changelog',
                'description' => 'Entidade Changelog com campos: version, title, description, type, category, author e date. Página de changelog com timeline agrupada por versão, badges coloridos por tipo, e tabela detalhada.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'Funcionalidade',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
            [
                'version' => '0.2.0',
                'title' => 'Migração da base de dados',
                'description' => 'Criação das migrations Doctrine para as tabelas user e changelog com todos os índices e constraints necessários.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'Base de Dados',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
            [
                'version' => '0.2.0',
                'title' => 'Envio de emails com Symfony Mailer + Mailtrap',
                'description' => 'Implementação do serviço MailerService para envio de emails transacionais usando Symfony Mailer com transporte Mailtrap. Template HTML de email para recuperação de palavra-passe com branding do portal, botão de ação e link de fallback.',
                'type' => Changelog::TYPE_FEATURE,
                'category' => 'Email',
                'author' => 'Simão Soares',
                'date' => '2026-02-09',
            ],
        ];
    }
}
