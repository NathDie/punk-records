<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261113112831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id BINARY(16) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE book (id BINARY(16) NOT NULL, title VARCHAR(255) NOT NULL, synopsis LONGTEXT DEFAULT NULL, published_at DATE NOT NULL, reading TINYINT NOT NULL, author_id BINARY(16) DEFAULT NULL, INDEX IDX_CBE5A331F675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE book_book_category (book_id BINARY(16) NOT NULL, book_category_id BINARY(16) NOT NULL, INDEX IDX_7A5A379416A2B381 (book_id), INDEX IDX_7A5A379440B1D29E (book_category_id), PRIMARY KEY (book_id, book_category_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE book_category (id BINARY(16) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE book_book_category ADD CONSTRAINT FK_7A5A379416A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_book_category ADD CONSTRAINT FK_7A5A379440B1D29E FOREIGN KEY (book_category_id) REFERENCES book_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE book_book_category DROP FOREIGN KEY FK_7A5A379416A2B381');
        $this->addSql('ALTER TABLE book_book_category DROP FOREIGN KEY FK_7A5A379440B1D29E');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_book_category');
        $this->addSql('DROP TABLE book_category');
    }
}
