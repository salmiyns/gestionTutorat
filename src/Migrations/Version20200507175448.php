<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507175448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE cours DROP CONSTRAINT fk_fdca8c9c80e95e18');
        $this->addSql('DROP INDEX idx_fdca8c9c80e95e18');
        $this->addSql('ALTER TABLE cours ADD compétences_req TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours DROP demande_id');
        $this->addSql('ALTER TABLE cours DROP logiciel_requise');
        $this->addSql('ALTER TABLE cours ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE cours ALTER description DROP DEFAULT');
        $this->addSql('ALTER TABLE cours ALTER objectif TYPE TEXT');
        $this->addSql('ALTER TABLE cours ALTER objectif DROP DEFAULT');
        $this->addSql('ALTER TABLE cours ALTER tag DROP NOT NULL');
        $this->addSql('ALTER TABLE cours ALTER date_creation SET NOT NULL');
        $this->addSql('ALTER TABLE cours ALTER dernier_modification SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cours ADD demande_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD logiciel_requise VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cours DROP compétences_req');
        $this->addSql('ALTER TABLE cours ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cours ALTER description DROP DEFAULT');
        $this->addSql('ALTER TABLE cours ALTER objectif TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cours ALTER objectif DROP DEFAULT');
        $this->addSql('ALTER TABLE cours ALTER tag SET NOT NULL');
        $this->addSql('ALTER TABLE cours ALTER date_creation DROP NOT NULL');
        $this->addSql('ALTER TABLE cours ALTER dernier_modification DROP NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT fk_fdca8c9c80e95e18 FOREIGN KEY (demande_id) REFERENCES demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fdca8c9c80e95e18 ON cours (demande_id)');
    }
}
