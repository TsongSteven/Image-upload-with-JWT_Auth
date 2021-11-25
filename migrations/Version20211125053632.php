<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125053632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6FBC9426823DEFB8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tags AS SELECT id, image_stock_id, tag_name FROM tags');
        $this->addSql('DROP TABLE tags');
        $this->addSql('CREATE TABLE tags (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, image_stock_id INTEGER DEFAULT NULL, tag_name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_6FBC9426823DEFB8 FOREIGN KEY (image_stock_id) REFERENCES image_stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tags (id, image_stock_id, tag_name) SELECT id, image_stock_id, tag_name FROM __temp__tags');
        $this->addSql('DROP TABLE __temp__tags');
        $this->addSql('CREATE INDEX IDX_6FBC9426823DEFB8 ON tags (image_stock_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6FBC9426823DEFB8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tags AS SELECT id, image_stock_id, tag_name FROM tags');
        $this->addSql('DROP TABLE tags');
        $this->addSql('CREATE TABLE tags (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, image_stock_id INTEGER DEFAULT NULL, tag_name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO tags (id, image_stock_id, tag_name) SELECT id, image_stock_id, tag_name FROM __temp__tags');
        $this->addSql('DROP TABLE __temp__tags');
        $this->addSql('CREATE INDEX IDX_6FBC9426823DEFB8 ON tags (image_stock_id)');
    }
}
