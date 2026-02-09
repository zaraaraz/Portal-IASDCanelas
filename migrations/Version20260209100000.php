<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260209100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create email_log table for tracking all sent emails';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE email_log (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT DEFAULT NULL,
            recipient_email VARCHAR(180) NOT NULL,
            recipient_name VARCHAR(255) DEFAULT NULL,
            subject VARCHAR(255) NOT NULL,
            type VARCHAR(50) NOT NULL,
            status VARCHAR(20) NOT NULL,
            error_message LONGTEXT DEFAULT NULL,
            sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            INDEX idx_email_log_recipient (recipient_email),
            INDEX idx_email_log_status (status),
            INDEX idx_email_log_type (type),
            INDEX IDX_6FB48833A76ED395 (user_id),
            CONSTRAINT FK_6FB48833A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE SET NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE email_log');
    }
}
