<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260928201046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inventory (id BINARY(16) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, quantity INT NOT NULL, purchase_date DATE DEFAULT NULL, purchase_price NUMERIC(10, 0) DEFAULT NULL, warranty_expires_at DATE DEFAULT NULL, equipment_status VARCHAR(255) NOT NULL, used_by_id BINARY(16) DEFAULT NULL, category_id BINARY(16) DEFAULT NULL, location_id BINARY(16) DEFAULT NULL, INDEX IDX_B12D4A364C2B72A8 (used_by_id), INDEX IDX_B12D4A3612469DE2 (category_id), INDEX IDX_B12D4A3664D218E (location_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE inventory_category (id BINARY(16) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE location (id BINARY(16) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A364C2B72A8 FOREIGN KEY (used_by_id) REFERENCES inventory (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A3612469DE2 FOREIGN KEY (category_id) REFERENCES inventory_category (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A3664D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A364C2B72A8');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A3612469DE2');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A3664D218E');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE inventory_category');
        $this->addSql('DROP TABLE location');
    }
}
