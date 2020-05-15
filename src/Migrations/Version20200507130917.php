<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507130917 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE inscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE inscription (id INT NOT NULL, tutore_id INT NOT NULL, realisation_id INT NOT NULL, date_inscrption DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E90F6D65899F888 ON inscription (tutore_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6B685E551 ON inscription (realisation_id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D65899F888 FOREIGN KEY (tutore_id) REFERENCES tutore (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6B685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande ADD titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE demande ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE realisation ADD cours_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD proposition_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD creer_par VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE realisation ADD modifier_par VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EDB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EAA5610E7ECF78B0 ON realisation (cours_id)');
        $this->addSql('CREATE INDEX IDX_EAA5610EDB96F9E ON realisation (proposition_id)');
        $this->addSql('ALTER TABLE seance ADD realisation_id INT NOT NULL');
        $this->addSql('ALTER TABLE seance ADD tuteur INT NOT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EB685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EB685E551 ON seance (realisation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE inscription_id_seq CASCADE');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0EB685E551');
        $this->addSql('DROP INDEX IDX_DF7DFD0EB685E551');
        $this->addSql('ALTER TABLE seance DROP realisation_id');
        $this->addSql('ALTER TABLE seance DROP tuteur');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610E7ECF78B0');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610EDB96F9E');
        $this->addSql('DROP INDEX IDX_EAA5610E7ECF78B0');
        $this->addSql('DROP INDEX IDX_EAA5610EDB96F9E');
        $this->addSql('ALTER TABLE realisation DROP cours_id');
        $this->addSql('ALTER TABLE realisation DROP proposition_id');
        $this->addSql('ALTER TABLE realisation DROP titre');
        $this->addSql('ALTER TABLE realisation DROP creer_par');
        $this->addSql('ALTER TABLE realisation DROP modifier_par');
        $this->addSql('ALTER TABLE demande DROP titre');
        $this->addSql('ALTER TABLE demande DROP description');
    }
}
