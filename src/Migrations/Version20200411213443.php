<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200411213443 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE remote_data_base (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, alias VARCHAR(50) NOT NULL, host VARCHAR(50) NOT NULL, port VARCHAR(50) NOT NULL, user VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, db VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_deleted BOOLEAN DEFAULT \'FALSE\' NOT NULL)');
        $this->addSql('DROP TABLE data_base');
        $this->addSql('CREATE TEMPORARY TABLE __temp__remote_table AS SELECT id, label, name, description, is_active FROM remote_table');
        $this->addSql('DROP TABLE remote_table');
        $this->addSql('CREATE TABLE remote_table (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, database_id INTEGER DEFAULT NULL, label VARCHAR(50) NOT NULL COLLATE BINARY, name VARCHAR(50) NOT NULL COLLATE BINARY, description VARCHAR(255) DEFAULT NULL COLLATE BINARY, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL, CONSTRAINT FK_9A31C9AF0AA09DB FOREIGN KEY (database_id) REFERENCES remote_data_base (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO remote_table (id, label, name, description, is_active) SELECT id, label, name, description, is_active FROM __temp__remote_table');
        $this->addSql('DROP TABLE __temp__remote_table');
        $this->addSql('CREATE INDEX IDX_9A31C9AF0AA09DB ON remote_table (database_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE data_base (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, alias VARCHAR(50) NOT NULL COLLATE BINARY, host VARCHAR(50) NOT NULL COLLATE BINARY, port VARCHAR(50) NOT NULL COLLATE BINARY, user VARCHAR(50) NOT NULL COLLATE BINARY, password VARCHAR(50) NOT NULL COLLATE BINARY, db VARCHAR(255) NOT NULL COLLATE BINARY, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_deleted BOOLEAN DEFAULT \'FALSE\' NOT NULL)');
        $this->addSql('DROP TABLE remote_data_base');
        $this->addSql('DROP INDEX IDX_9A31C9AF0AA09DB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__remote_table AS SELECT id, label, name, description, is_active FROM remote_table');
        $this->addSql('DROP TABLE remote_table');
        $this->addSql('CREATE TABLE remote_table (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL)');
        $this->addSql('INSERT INTO remote_table (id, label, name, description, is_active) SELECT id, label, name, description, is_active FROM __temp__remote_table');
        $this->addSql('DROP TABLE __temp__remote_table');
    }
}
