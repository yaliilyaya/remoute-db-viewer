<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200411225159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_F14321A3ECFF285C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__remote_table_column AS SELECT id, table_id, label, name, type, description, is_view_list, is_view_detail, is_view_popup FROM remote_table_column');
        $this->addSql('DROP TABLE remote_table_column');
        $this->addSql('CREATE TABLE remote_table_column (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, table_id INTEGER DEFAULT NULL, label VARCHAR(50) NOT NULL COLLATE BINARY, name VARCHAR(50) NOT NULL COLLATE BINARY, type VARCHAR(50) NOT NULL COLLATE BINARY, description VARCHAR(255) DEFAULT NULL COLLATE BINARY, is_view_list BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_view_detail BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_view_popup BOOLEAN DEFAULT \'TRUE\' NOT NULL, CONSTRAINT FK_F14321A3ECFF285C FOREIGN KEY (table_id) REFERENCES remote_table (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO remote_table_column (id, table_id, label, name, type, description, is_view_list, is_view_detail, is_view_popup) SELECT id, table_id, label, name, type, description, is_view_list, is_view_detail, is_view_popup FROM __temp__remote_table_column');
        $this->addSql('DROP TABLE __temp__remote_table_column');
        $this->addSql('CREATE INDEX IDX_F14321A3ECFF285C ON remote_table_column (table_id)');
        $this->addSql('DROP INDEX IDX_9A31C9AF0AA09DB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__remote_table AS SELECT id, database_id, label, name, description, is_active FROM remote_table');
        $this->addSql('DROP TABLE remote_table');
        $this->addSql('CREATE TABLE remote_table (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, database_id INTEGER DEFAULT NULL, label VARCHAR(50) NOT NULL COLLATE BINARY, name VARCHAR(50) NOT NULL COLLATE BINARY, description VARCHAR(255) DEFAULT NULL COLLATE BINARY, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL, CONSTRAINT FK_9A31C9AF0AA09DB FOREIGN KEY (database_id) REFERENCES remote_data_base (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO remote_table (id, database_id, label, name, description, is_active) SELECT id, database_id, label, name, description, is_active FROM __temp__remote_table');
        $this->addSql('DROP TABLE __temp__remote_table');
        $this->addSql('CREATE INDEX IDX_9A31C9AF0AA09DB ON remote_table (database_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_9A31C9AF0AA09DB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__remote_table AS SELECT id, database_id, label, name, description, is_active FROM remote_table');
        $this->addSql('DROP TABLE remote_table');
        $this->addSql('CREATE TABLE remote_table (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, database_id INTEGER DEFAULT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL)');
        $this->addSql('INSERT INTO remote_table (id, database_id, label, name, description, is_active) SELECT id, database_id, label, name, description, is_active FROM __temp__remote_table');
        $this->addSql('DROP TABLE __temp__remote_table');
        $this->addSql('CREATE INDEX IDX_9A31C9AF0AA09DB ON remote_table (database_id)');
        $this->addSql('DROP INDEX IDX_F14321A3ECFF285C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__remote_table_column AS SELECT id, table_id, label, name, type, description, is_view_list, is_view_detail, is_view_popup FROM remote_table_column');
        $this->addSql('DROP TABLE remote_table_column');
        $this->addSql('CREATE TABLE remote_table_column (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, table_id INTEGER DEFAULT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_view_list BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_view_detail BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_view_popup BOOLEAN DEFAULT \'TRUE\' NOT NULL)');
        $this->addSql('INSERT INTO remote_table_column (id, table_id, label, name, type, description, is_view_list, is_view_detail, is_view_popup) SELECT id, table_id, label, name, type, description, is_view_list, is_view_detail, is_view_popup FROM __temp__remote_table_column');
        $this->addSql('DROP TABLE __temp__remote_table_column');
        $this->addSql('CREATE INDEX IDX_F14321A3ECFF285C ON remote_table_column (table_id)');
    }
}
