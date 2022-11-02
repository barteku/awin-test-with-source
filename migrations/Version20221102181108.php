<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221102181108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_office_team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, preferred_contact_service INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coffee_break_preference (id INT AUTO_INCREMENT NOT NULL, requested_by INT DEFAULT NULL, type VARCHAR(255) NOT NULL, sub_type VARCHAR(255) NOT NULL, requested_date DATETIME NOT NULL, details JSON NOT NULL, INDEX IDX_BEF5C85818C491A5 (requested_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff_member (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, hip_chat_identifier VARCHAR(255) DEFAULT NULL, INDEX IDX_759948C3296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coffee_break_preference ADD CONSTRAINT FK_BEF5C85818C491A5 FOREIGN KEY (requested_by) REFERENCES staff_member (id)');
        $this->addSql('ALTER TABLE staff_member ADD CONSTRAINT FK_759948C3296CD8AE FOREIGN KEY (team_id) REFERENCES app_office_team (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE staff_member DROP FOREIGN KEY FK_759948C3296CD8AE');
        $this->addSql('ALTER TABLE coffee_break_preference DROP FOREIGN KEY FK_BEF5C85818C491A5');
        $this->addSql('DROP TABLE app_office_team');
        $this->addSql('DROP TABLE coffee_break_preference');
        $this->addSql('DROP TABLE staff_member');
    }
}
