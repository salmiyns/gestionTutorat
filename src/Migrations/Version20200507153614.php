<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507153614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT fk_717e22e3a76ed395');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT fk_717e22e3ed766068');
        $this->addSql('DROP INDEX uniq_717e22e3a76ed395');
        $this->addSql('DROP INDEX uniq_717e22e3ed766068');
        $this->addSql('ALTER TABLE etudiant ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant DROP user_id');
        $this->addSql('ALTER TABLE etudiant DROP username_id');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E39D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E39D86650F ON etudiant (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT FK_717E22E39D86650F');
        $this->addSql('DROP INDEX UNIQ_717E22E39D86650F');
        $this->addSql('ALTER TABLE etudiant ADD username_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT fk_717e22e3a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT fk_717e22e3ed766068 FOREIGN KEY (username_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_717e22e3a76ed395 ON etudiant (user_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_717e22e3ed766068 ON etudiant (username_id)');
    }
}
