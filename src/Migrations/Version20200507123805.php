<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507123805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE cours (id INT NOT NULL, demande_id INT NOT NULL, nom_cours VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, objectif VARCHAR(255) DEFAULT NULL, tag VARCHAR(255) NOT NULL, logiciel_requise VARCHAR(255) DEFAULT NULL, niveau VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, dernier_modification DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C80E95E18 ON cours (demande_id)');
        $this->addSql('CREATE TABLE demande (id INT NOT NULL, tutore_id INT NOT NULL, id_etudiant INT NOT NULL, date_creation DATE NOT NULL, date_modification DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2694D7A55899F888 ON demande (tutore_id)');
        $this->addSql('CREATE TABLE tutore (id INT NOT NULL, etudiant_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9744B4BEDDEAB1A3 ON tutore (etudiant_id)');
        $this->addSql('CREATE TABLE proposition (id INT NOT NULL, tuteur_id INT NOT NULL, cours INT NOT NULL, date_creation DATE NOT NULL, date_modification DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7CDC35386EC68D8 ON proposition (tuteur_id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A55899F888 FOREIGN KEY (tutore_id) REFERENCES tutore (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tutore ADD CONSTRAINT FK_9744B4BEDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC35386EC68D8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9C80E95E18');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A55899F888');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE tutore');
        $this->addSql('DROP TABLE proposition');
    }
}
