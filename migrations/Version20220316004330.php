<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316004330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE column_decorator (id INT AUTO_INCREMENT NOT NULL, column_id INT DEFAULT NULL, parameter JSON NOT NULL, discriminator VARCHAR(255) NOT NULL, INDEX IDX_C251396DBE8E8ED5 (column_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remote_data_base (id INT AUTO_INCREMENT NOT NULL, alias VARCHAR(50) NOT NULL, host VARCHAR(50) NOT NULL, port VARCHAR(50) NOT NULL, user VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, db VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, is_deleted TINYINT(1) DEFAULT \'0\' NOT NULL, charset VARCHAR(40) DEFAULT \'UTF8\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remote_relative (id INT AUTO_INCREMENT NOT NULL, column_from_id INT DEFAULT NULL, column_to_id INT DEFAULT NULL, INDEX IDX_BDC9489573B5318F (column_from_id), INDEX IDX_BDC94895D72FD85 (column_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remote_table (id INT AUTO_INCREMENT NOT NULL, database_id INT DEFAULT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_9A31C9AF0AA09DB (database_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remote_table_column (id INT AUTO_INCREMENT NOT NULL, table_id INT DEFAULT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_view_list TINYINT(1) DEFAULT \'1\' NOT NULL, is_view_detail TINYINT(1) DEFAULT \'1\' NOT NULL, is_view_popup TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_F14321A3ECFF285C (table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE column_decorator ADD CONSTRAINT FK_C251396DBE8E8ED5 FOREIGN KEY (column_id) REFERENCES remote_table_column (id)');
        $this->addSql('ALTER TABLE remote_relative ADD CONSTRAINT FK_BDC9489573B5318F FOREIGN KEY (column_from_id) REFERENCES remote_table_column (id)');
        $this->addSql('ALTER TABLE remote_relative ADD CONSTRAINT FK_BDC94895D72FD85 FOREIGN KEY (column_to_id) REFERENCES remote_table_column (id)');
        $this->addSql('ALTER TABLE remote_table ADD CONSTRAINT FK_9A31C9AF0AA09DB FOREIGN KEY (database_id) REFERENCES remote_data_base (id)');
        $this->addSql('ALTER TABLE remote_table_column ADD CONSTRAINT FK_F14321A3ECFF285C FOREIGN KEY (table_id) REFERENCES remote_table (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remote_table DROP FOREIGN KEY FK_9A31C9AF0AA09DB');
        $this->addSql('ALTER TABLE remote_table_column DROP FOREIGN KEY FK_F14321A3ECFF285C');
        $this->addSql('ALTER TABLE column_decorator DROP FOREIGN KEY FK_C251396DBE8E8ED5');
        $this->addSql('ALTER TABLE remote_relative DROP FOREIGN KEY FK_BDC9489573B5318F');
        $this->addSql('ALTER TABLE remote_relative DROP FOREIGN KEY FK_BDC94895D72FD85');
        $this->addSql('DROP TABLE column_decorator');
        $this->addSql('DROP TABLE remote_data_base');
        $this->addSql('DROP TABLE remote_relative');
        $this->addSql('DROP TABLE remote_table');
        $this->addSql('DROP TABLE remote_table_column');
    }
}
