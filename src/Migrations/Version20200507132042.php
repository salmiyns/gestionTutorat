<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507132042 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE seance ADD tuteur INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E39D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E39D86650F ON etudiant (user_id_id)');
        $this->addSql('ALTER TABLE proposition ADD titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE proposition ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA19D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81A72FA19D86650F ON enseignant (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE enseignant DROP CONSTRAINT FK_81A72FA19D86650F');
        $this->addSql('DROP INDEX UNIQ_81A72FA19D86650F');
        $this->addSql('ALTER TABLE enseignant DROP user_id_id');
        $this->addSql('ALTER TABLE seance DROP tuteur');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT FK_717E22E39D86650F');
        $this->addSql('DROP INDEX UNIQ_717E22E39D86650F');
        $this->addSql('ALTER TABLE etudiant DROP user_id_id');
        $this->addSql('ALTER TABLE proposition DROP titre');
        $this->addSql('ALTER TABLE proposition DROP description');
    }
}
