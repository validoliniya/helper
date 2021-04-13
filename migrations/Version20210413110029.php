<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413110029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `hms_command` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, template VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hms_database (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `hms_field` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `hms_field_types` (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `hms_operation` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, template VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `hms_table` (id INT AUTO_INCREMENT NOT NULL, database_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5A0F8AB7F0AA09DB (database_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_fields (id INT AUTO_INCREMENT NOT NULL, hms_table_id INT NOT NULL, field_id INT NOT NULL, INDEX IDX_2037E64BF78340AF (hms_table_id), INDEX IDX_2037E64B443707B0 (field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `hms_table` ADD CONSTRAINT FK_5A0F8AB7F0AA09DB FOREIGN KEY (database_id) REFERENCES hms_database (id)');
        $this->addSql('ALTER TABLE table_fields ADD CONSTRAINT FK_2037E64BF78340AF FOREIGN KEY (hms_table_id) REFERENCES `hms_table` (id)');
        $this->addSql('ALTER TABLE table_fields ADD CONSTRAINT FK_2037E64B443707B0 FOREIGN KEY (field_id) REFERENCES `hms_field` (id)');
        $this->addSql('DROP TABLE databases_table');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `hms_table` DROP FOREIGN KEY FK_5A0F8AB7F0AA09DB');
        $this->addSql('ALTER TABLE table_fields DROP FOREIGN KEY FK_2037E64B443707B0');
        $this->addSql('ALTER TABLE table_fields DROP FOREIGN KEY FK_2037E64BF78340AF');
        $this->addSql('CREATE TABLE databases_table (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE `hms_command`');
        $this->addSql('DROP TABLE hms_database');
        $this->addSql('DROP TABLE `hms_field`');
        $this->addSql('DROP TABLE `hms_field_types`');
        $this->addSql('DROP TABLE `hms_operation`');
        $this->addSql('DROP TABLE `hms_table`');
        $this->addSql('DROP TABLE table_fields');
        $this->addSql('DROP TABLE user');
    }
}
