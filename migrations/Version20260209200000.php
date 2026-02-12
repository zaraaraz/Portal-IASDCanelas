<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260209200000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop changelog table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS changelog');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE changelog (
            id INT AUTO_INCREMENT NOT NULL,
            version VARCHAR(20) NOT NULL,
            title VARCHAR(255) NOT NULL,
            description LONGTEXT NOT NULL,
            type VARCHAR(20) NOT NULL,
            author VARCHAR(100) DEFAULT NULL,
            category VARCHAR(100) DEFAULT NULL,
            date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }
}
