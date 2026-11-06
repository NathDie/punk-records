<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261106144600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maintenance_log (id BINARY(16) NOT NULL, done_at DATE NOT NULL, note LONGTEXT DEFAULT NULL, maintenance_id BINARY(16) DEFAULT NULL, INDEX IDX_26CA3DF3F6C202BC (maintenance_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE maintenance_log ADD CONSTRAINT FK_26CA3DF3F6C202BC FOREIGN KEY (maintenance_id) REFERENCES maintenance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenance_log DROP FOREIGN KEY FK_26CA3DF3F6C202BC');
        $this->addSql('DROP TABLE maintenance_log');
    }
}
