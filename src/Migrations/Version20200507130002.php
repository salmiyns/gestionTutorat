<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507130002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE seance ADD realisation_id INT NOT NULL');
        $this->addSql('ALTER TABLE seance ADD tuteur INT NOT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EB685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EB685E551 ON seance (realisation_id)');
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
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
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
