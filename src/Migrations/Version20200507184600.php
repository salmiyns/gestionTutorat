<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507184600 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE seance (id INT NOT NULL, realisation_id INT NOT NULL, cours INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, classe VARCHAR(255) NOT NULL, objectif TEXT NOT NULL, tuteur INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EB685E551 ON seance (realisation_id)');
        $this->addSql('CREATE TABLE inscription (id INT NOT NULL, tutore_id INT NOT NULL, realisation_id INT NOT NULL, date_inscrption DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E90F6D65899F888 ON inscription (tutore_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6B685E551 ON inscription (realisation_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, date_of_birth VARCHAR(255) NOT NULL, profile_pic VARCHAR(255) DEFAULT NULL, activation_code VARCHAR(255) DEFAULT NULL, registration_date DATE DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE cours (id INT NOT NULL, nom_cours VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, objectif TEXT DEFAULT NULL, tag VARCHAR(255) DEFAULT NULL, compétences_req TEXT DEFAULT NULL, niveau VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, date_creation DATE NOT NULL, dernier_modification DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE etudiant (id INT NOT NULL, user_id_id INT NOT NULL, matricule VARCHAR(255) NOT NULL, filiere VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E39D86650F ON etudiant (user_id_id)');
        $this->addSql('CREATE TABLE demande (id INT NOT NULL, tutore_id INT NOT NULL, cours_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2694D7A55899F888 ON demande (tutore_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A57ECF78B0 ON demande (cours_id)');
        $this->addSql('CREATE TABLE tuteur (id INT NOT NULL, id_etudiant_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_56412268C5F87C54 ON tuteur (id_etudiant_id)');
        $this->addSql('CREATE TABLE tutore (id INT NOT NULL, etudiant_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9744B4BEDDEAB1A3 ON tutore (etudiant_id)');
        $this->addSql('CREATE TABLE proposition (id INT NOT NULL, cours_id INT NOT NULL, tuteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, date_creation DATE NOT NULL, date_modification DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7CDC3537ECF78B0 ON proposition (cours_id)');
        $this->addSql('CREATE INDEX IDX_C7CDC35386EC68D8 ON proposition (tuteur_id)');
        $this->addSql('CREATE TABLE enseignant (id INT NOT NULL, user_id_id INT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81A72FA19D86650F ON enseignant (user_id_id)');
        $this->addSql('CREATE TABLE realisation (id INT NOT NULL, cours_id INT NOT NULL, proposition_id INT NOT NULL, date_creation DATE NOT NULL, date_modification DATE NOT NULL, titre VARCHAR(255) NOT NULL, creer_par VARCHAR(255) DEFAULT NULL, modifier_par VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EAA5610E7ECF78B0 ON realisation (cours_id)');
        $this->addSql('CREATE INDEX IDX_EAA5610EDB96F9E ON realisation (proposition_id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EB685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D65899F888 FOREIGN KEY (tutore_id) REFERENCES tutore (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6B685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E39D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A55899F888 FOREIGN KEY (tutore_id) REFERENCES tutore (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A57ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tuteur ADD CONSTRAINT FK_56412268C5F87C54 FOREIGN KEY (id_etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tutore ADD CONSTRAINT FK_9744B4BEDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC3537ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC35386EC68D8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA19D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EDB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT FK_717E22E39D86650F');
        $this->addSql('ALTER TABLE enseignant DROP CONSTRAINT FK_81A72FA19D86650F');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A57ECF78B0');
        $this->addSql('ALTER TABLE proposition DROP CONSTRAINT FK_C7CDC3537ECF78B0');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610E7ECF78B0');
        $this->addSql('ALTER TABLE tuteur DROP CONSTRAINT FK_56412268C5F87C54');
        $this->addSql('ALTER TABLE tutore DROP CONSTRAINT FK_9744B4BEDDEAB1A3');
        $this->addSql('ALTER TABLE proposition DROP CONSTRAINT FK_C7CDC35386EC68D8');
        $this->addSql('ALTER TABLE inscription DROP CONSTRAINT FK_5E90F6D65899F888');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A55899F888');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610EDB96F9E');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0EB685E551');
        $this->addSql('ALTER TABLE inscription DROP CONSTRAINT FK_5E90F6D6B685E551');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE tuteur');
        $this->addSql('DROP TABLE tutore');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE realisation');
    }
}
