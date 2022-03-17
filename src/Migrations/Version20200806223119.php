<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200806223119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE remote_data_base ADD COLUMN charset VARCHAR(40) DEFAULT \'UTF8\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__remote_data_base AS SELECT id, alias, host, port, user, password, db, is_active, is_deleted FROM remote_data_base');
        $this->addSql('DROP TABLE remote_data_base');
        $this->addSql('CREATE TABLE remote_data_base (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, alias VARCHAR(50) NOT NULL, host VARCHAR(50) NOT NULL, port VARCHAR(50) NOT NULL, user VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, db VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT \'TRUE\' NOT NULL, is_deleted BOOLEAN DEFAULT \'FALSE\' NOT NULL)');
        $this->addSql('INSERT INTO remote_data_base (id, alias, host, port, user, password, db, is_active, is_deleted) SELECT id, alias, host, port, user, password, db, is_active, is_deleted FROM __temp__remote_data_base');
        $this->addSql('DROP TABLE __temp__remote_data_base');

    }
}
