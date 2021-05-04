<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504053030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command_section (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hms_command ADD section_id INT NOT NULL');
        $this->addSql('ALTER TABLE hms_command ADD CONSTRAINT FK_F3076281D823E37A FOREIGN KEY (section_id) REFERENCES command_section (id)');
        $this->addSql('CREATE INDEX IDX_F3076281D823E37A ON hms_command (section_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `hms_command` DROP FOREIGN KEY FK_F3076281D823E37A');
        $this->addSql('DROP TABLE command_section');
        $this->addSql('DROP INDEX IDX_F3076281D823E37A ON `hms_command`');
        $this->addSql('ALTER TABLE `hms_command` DROP section_id');
    }
}
