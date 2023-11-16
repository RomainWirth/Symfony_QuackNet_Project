<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116104409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, user_id_id, content, created_at, picture, tags, motherquack_id FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id_id INTEGER NOT NULL, motherquack_id_id INTEGER DEFAULT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL, tags VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_83D44F6F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_83D44F6FA98DCD FOREIGN KEY (motherquack_id_id) REFERENCES quack (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack (id, user_id_id, content, created_at, picture, tags, motherquack_id_id) SELECT id, user_id_id, content, created_at, picture, tags, motherquack_id FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6F9D86650F ON quack (user_id_id)');
        $this->addSql('CREATE INDEX IDX_83D44F6FA98DCD ON quack (motherquack_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, user_id_id, motherquack_id_id, content, created_at, picture, tags FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id_id INTEGER NOT NULL, motherquack_id INTEGER DEFAULT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL, tags VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_83D44F6F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack (id, user_id_id, motherquack_id, content, created_at, picture, tags) SELECT id, user_id_id, motherquack_id_id, content, created_at, picture, tags FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6F9D86650F ON quack (user_id_id)');
    }
}
