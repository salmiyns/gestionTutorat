<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507183345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE tuteur ADD proposition_id INT NOT NULL');
        $this->addSql('ALTER TABLE tuteur ADD CONSTRAINT FK_56412268DB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_56412268DB96F9E ON tuteur (proposition_id)');
        $this->addSql('ALTER TABLE proposition DROP CONSTRAINT fk_c7cdc35386ec68d8');
        $this->addSql('DROP INDEX idx_c7cdc35386ec68d8');
        $this->addSql('ALTER TABLE proposition DROP tuteur_id');
        $this->addSql('ALTER TABLE proposition RENAME COLUMN description TO deiscription');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE proposition ADD tuteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE proposition RENAME COLUMN deiscription TO description');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT fk_c7cdc35386ec68d8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c7cdc35386ec68d8 ON proposition (tuteur_id)');
        $this->addSql('ALTER TABLE tuteur DROP CONSTRAINT FK_56412268DB96F9E');
        $this->addSql('DROP INDEX IDX_56412268DB96F9E');
        $this->addSql('ALTER TABLE tuteur DROP proposition_id');
    }
}
