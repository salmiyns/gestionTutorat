<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200610211400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE enseignant_id_seq CASCADE');
        $this->addSql('ALTER TABLE "user" DROP type');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT fk_717e22e39d86650f');
        $this->addSql('DROP INDEX idx_717e22e39d86650f');
        $this->addSql('ALTER TABLE etudiant DROP user_id_id');
        $this->addSql('ALTER TABLE enseignant ADD email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD first_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ADD last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ADD date_of_birth VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD profile_pic VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ADD activation_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ADD registration_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD telephone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ADD sexe VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ADD about TEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81A72FA1E7927C74 ON enseignant (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE enseignant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE "user" ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT fk_717e22e39d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_717e22e39d86650f ON etudiant (user_id_id)');
        $this->addSql('DROP INDEX UNIQ_81A72FA1E7927C74');
        $this->addSql('ALTER TABLE enseignant DROP email');
        $this->addSql('ALTER TABLE enseignant DROP roles');
        $this->addSql('ALTER TABLE enseignant DROP password');
        $this->addSql('ALTER TABLE enseignant DROP first_name');
        $this->addSql('ALTER TABLE enseignant DROP last_name');
        $this->addSql('ALTER TABLE enseignant DROP date_of_birth');
        $this->addSql('ALTER TABLE enseignant DROP profile_pic');
        $this->addSql('ALTER TABLE enseignant DROP activation_code');
        $this->addSql('ALTER TABLE enseignant DROP registration_date');
        $this->addSql('ALTER TABLE enseignant DROP status');
        $this->addSql('ALTER TABLE enseignant DROP telephone');
        $this->addSql('ALTER TABLE enseignant DROP sexe');
        $this->addSql('ALTER TABLE enseignant DROP adresse');
        $this->addSql('ALTER TABLE enseignant DROP about');
    }
}
