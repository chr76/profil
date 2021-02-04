<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201170949 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD knowledge_id INT DEFAULT NULL, ADD type VARCHAR(255) DEFAULT NULL, CHANGE content content VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66E7DC6902 FOREIGN KEY (knowledge_id) REFERENCES knowledge (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66E7DC6902 ON article (knowledge_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66E7DC6902');
        $this->addSql('DROP INDEX UNIQ_23A0E66E7DC6902 ON article');
        $this->addSql('ALTER TABLE article DROP knowledge_id, DROP type, CHANGE content content TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
