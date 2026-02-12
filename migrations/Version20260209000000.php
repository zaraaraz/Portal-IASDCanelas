<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration: Create user and changelog tables
 */
final class Version20260209000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user and changelog tables for authentication and changelog system';
    }

    public function up(Schema $schema): void
    {
        // User table
        $this->addSql('CREATE TABLE `user` (
            id INT AUTO_INCREMENT NOT NULL,
            email VARCHAR(180) NOT NULL,
            full_name VARCHAR(255) NOT NULL,
            roles JSON NOT NULL,
            password VARCHAR(255) NOT NULL,
            is_verified TINYINT(1) NOT NULL DEFAULT 0,
            reset_token VARCHAR(255) DEFAULT NULL,
            reset_token_expires_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            UNIQUE INDEX UNIQ_8D93D649E7927C74 (email),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Changelog table
        $this->addSql('CREATE TABLE changelog (
            id INT AUTO_INCREMENT NOT NULL,
            version VARCHAR(20) NOT NULL,
            title VARCHAR(255) NOT NULL,
            description LONGTEXT NOT NULL,
            type VARCHAR(30) NOT NULL,
            author VARCHAR(100) DEFAULT NULL,
            category VARCHAR(50) DEFAULT NULL,
            date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\',
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE changelog');
    }
}
