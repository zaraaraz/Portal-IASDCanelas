<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260209210000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create role table and seed church roles';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `role` (
            id INT AUTO_INCREMENT NOT NULL,
            code VARCHAR(50) NOT NULL,
            display_name VARCHAR(100) NOT NULL,
            description VARCHAR(255) DEFAULT NULL,
            badge_color VARCHAR(20) DEFAULT NULL,
            sort_order INT NOT NULL DEFAULT 0,
            UNIQUE INDEX UNIQ_57698A6A77153098 (code),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Seed church roles
        $this->addSql("INSERT INTO `role` (code, display_name, description, badge_color, sort_order) VALUES
            ('ROLE_ADMIN', 'Administrador', 'Administrador do portal com acesso total', 'danger', 1),
            ('ROLE_PASTOR', 'Pastor', 'Pastor da igreja', 'primary', 2),
            ('ROLE_ANCIAO', 'Ancião', 'Ancião da igreja', 'info', 3),
            ('ROLE_DIACONO', 'Diácono', 'Diácono / Diaconisa', 'info', 4),
            ('ROLE_TESOUREIRO', 'Tesoureiro(a)', 'Tesoureiro(a) da igreja', 'warning', 5),
            ('ROLE_SECRETARIO', 'Secretário(a)', 'Secretário(a) da igreja', 'warning', 6),
            ('ROLE_MULTIMEDIA', 'Equipa Multimédia', 'Membro da equipa de multimédia e transmissão', 'success', 7),
            ('ROLE_LOUVOR', 'Equipa de Louvor', 'Membro da equipa de louvor e música', 'success', 8),
            ('ROLE_ESCOLA_SABATINA', 'Escola Sabatina', 'Responsável ou professor da Escola Sabatina', 'success', 9),
            ('ROLE_DESBRAVADORES', 'Desbravadores', 'Líder ou conselheiro dos Desbravadores', 'success', 10),
            ('ROLE_USER', 'Membro', 'Membro regular da igreja', 'secondary', 99)
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `role`');
    }
}
