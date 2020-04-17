<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200417233418 extends AbstractMigration
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
        $this->addSql('CREATE TABLE remote_table_column (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, table_id INTEGER DEFAULT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_view_list BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_view_detail BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_view_popup BOOLEAN DEFAULT \'TRUE\' NOT NULL)');
        $this->addSql('CREATE INDEX IDX_F14321A3ECFF285C ON remote_table_column (table_id)');
        $this->addSql('CREATE TABLE remote_table (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, database_id INTEGER DEFAULT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9A31C9AF0AA09DB ON remote_table (database_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE remote_data_base');
        $this->addSql('DROP TABLE remote_table_column');
        $this->addSql('DROP TABLE remote_table');
    }
}
