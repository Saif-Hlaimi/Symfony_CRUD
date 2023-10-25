<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024111638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE joueurs (id INT AUTO_INCREMENT NOT NULL, matchs_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_F0FD889D88EB7468 (matchs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joueurs ADD CONSTRAINT FK_F0FD889D88EB7468 FOREIGN KEY (matchs_id) REFERENCES matchs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueurs DROP FOREIGN KEY FK_F0FD889D88EB7468');
        $this->addSql('DROP TABLE joueurs');
    }
}
