<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200419234628 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE seance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE demande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tuteur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE proposition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE enseignant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE realisation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE seance (id INT NOT NULL, cours INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, classe VARCHAR(255) NOT NULL, objectif TEXT NOT NULL, tuteur INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE demande (id INT NOT NULL, id_etudiant INT NOT NULL, date_creation DATE NOT NULL, date_modification DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tuteur (id INT NOT NULL, id_etudiant INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE proposition (id INT NOT NULL, tuteur INT NOT NULL, cours INT NOT NULL, date_creation DATE NOT NULL, date_modification DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE enseignant (id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE realisation (id INT NOT NULL, date_creation DATE NOT NULL, date_modification DATE NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE seance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE demande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tuteur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE proposition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE enseignant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE realisation_id_seq CASCADE');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE tuteur');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE realisation');
    }
}
