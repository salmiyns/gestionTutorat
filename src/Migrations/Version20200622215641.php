<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622215641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE proposition DROP CONSTRAINT fk_c7cdc35386ec68d8');
        $this->addSql('DROP INDEX idx_c7cdc35386ec68d8');
        $this->addSql('ALTER TABLE proposition DROP tuteur_id');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT fk_eaa5610e86ec68d8');
        $this->addSql('DROP INDEX idx_eaa5610e86ec68d8');
        $this->addSql('ALTER TABLE realisation DROP tuteur_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE realisation ADD tuteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT fk_eaa5610e86ec68d8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_eaa5610e86ec68d8 ON realisation (tuteur_id)');
        $this->addSql('ALTER TABLE proposition ADD tuteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT fk_c7cdc35386ec68d8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c7cdc35386ec68d8 ON proposition (tuteur_id)');
    }
}
