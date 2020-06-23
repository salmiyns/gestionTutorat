<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622232740 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE tuteurr_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tuteurr (id INT NOT NULL, etudiant_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F3657D5DDEAB1A3 ON tuteurr (etudiant_id)');
        $this->addSql('ALTER TABLE tuteurr ADD CONSTRAINT FK_2F3657D5DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE proposition ADD tuteurr_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC353D7436CCE FOREIGN KEY (tuteurr_id) REFERENCES tuteurr (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C7CDC353D7436CCE ON proposition (tuteurr_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE proposition DROP CONSTRAINT FK_C7CDC353D7436CCE');
        $this->addSql('DROP SEQUENCE tuteurr_id_seq CASCADE');
        $this->addSql('DROP TABLE tuteurr');
        $this->addSql('DROP INDEX IDX_C7CDC353D7436CCE');
        $this->addSql('ALTER TABLE proposition DROP tuteurr_id');
    }
}
