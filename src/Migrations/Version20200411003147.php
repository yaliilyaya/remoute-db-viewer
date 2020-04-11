<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200411003147 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE remote_table (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL)');
        $this->addSql('DROP TABLE "table"');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE "table" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(50) NOT NULL COLLATE BINARY, name VARCHAR(50) NOT NULL COLLATE BINARY, description VARCHAR(255) NOT NULL COLLATE BINARY, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL)');
        $this->addSql('DROP TABLE remote_table');
    }
}
