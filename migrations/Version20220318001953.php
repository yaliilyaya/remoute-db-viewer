<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318001953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE column_decorator (id INT AUTO_INCREMENT NOT NULL, column_id INT DEFAULT NULL, parameter JSON NOT NULL, discriminator VARCHAR(255) NOT NULL, INDEX IDX_C251396DBE8E8ED5 (column_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE column_info (id INT AUTO_INCREMENT NOT NULL, table_id INT DEFAULT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_view_list TINYINT(1) DEFAULT \'1\' NOT NULL, is_view_detail TINYINT(1) DEFAULT \'1\' NOT NULL, is_view_popup TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_54AB0632ECFF285C (table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_base_info (id INT AUTO_INCREMENT NOT NULL, alias VARCHAR(50) NOT NULL, host VARCHAR(50) NOT NULL, port VARCHAR(50) NOT NULL, user VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, db VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, is_deleted TINYINT(1) DEFAULT \'0\' NOT NULL, charset VARCHAR(40) DEFAULT \'UTF8\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relative_info (id INT AUTO_INCREMENT NOT NULL, column_from_id INT DEFAULT NULL, column_to_id INT DEFAULT NULL, INDEX IDX_E4221B0473B5318F (column_from_id), INDEX IDX_E4221B04D72FD85 (column_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_info (id INT AUTO_INCREMENT NOT NULL, database_id INT DEFAULT NULL, label VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_815F719CF0AA09DB (database_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE column_decorator ADD CONSTRAINT FK_C251396DBE8E8ED5 FOREIGN KEY (column_id) REFERENCES column_info (id)');
        $this->addSql('ALTER TABLE column_info ADD CONSTRAINT FK_54AB0632ECFF285C FOREIGN KEY (table_id) REFERENCES table_info (id)');
        $this->addSql('ALTER TABLE relative_info ADD CONSTRAINT FK_E4221B0473B5318F FOREIGN KEY (column_from_id) REFERENCES column_info (id)');
        $this->addSql('ALTER TABLE relative_info ADD CONSTRAINT FK_E4221B04D72FD85 FOREIGN KEY (column_to_id) REFERENCES column_info (id)');
        $this->addSql('ALTER TABLE table_info ADD CONSTRAINT FK_815F719CF0AA09DB FOREIGN KEY (database_id) REFERENCES data_base_info (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE column_decorator DROP FOREIGN KEY FK_C251396DBE8E8ED5');
        $this->addSql('ALTER TABLE relative_info DROP FOREIGN KEY FK_E4221B0473B5318F');
        $this->addSql('ALTER TABLE relative_info DROP FOREIGN KEY FK_E4221B04D72FD85');
        $this->addSql('ALTER TABLE table_info DROP FOREIGN KEY FK_815F719CF0AA09DB');
        $this->addSql('ALTER TABLE column_info DROP FOREIGN KEY FK_54AB0632ECFF285C');
        $this->addSql('DROP TABLE column_decorator');
        $this->addSql('DROP TABLE column_info');
        $this->addSql('DROP TABLE data_base_info');
        $this->addSql('DROP TABLE relative_info');
        $this->addSql('DROP TABLE table_info');
    }
}
