<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507172357 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE demande DROP date_creation');
        $this->addSql('ALTER TABLE demande DROP date_modification');
        $this->addSql('ALTER TABLE demande DROP titre');
        $this->addSql('ALTER TABLE demande DROP description');
        $this->addSql('ALTER TABLE demande RENAME COLUMN id_etudiant TO cours_id');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A57ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2694D7A57ECF78B0 ON demande (cours_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A57ECF78B0');
        $this->addSql('DROP INDEX IDX_2694D7A57ECF78B0');
        $this->addSql('ALTER TABLE demande ADD date_creation DATE NOT NULL');
        $this->addSql('ALTER TABLE demande ADD date_modification DATE NOT NULL');
        $this->addSql('ALTER TABLE demande ADD titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE demande ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande RENAME COLUMN cours_id TO id_etudiant');
    }
}
