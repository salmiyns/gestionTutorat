<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527205345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT fk_eaa5610edb96f9e');
        $this->addSql('DROP INDEX idx_eaa5610edb96f9e');
        $this->addSql('ALTER TABLE realisation DROP proposition_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE realisation ADD proposition_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT fk_eaa5610edb96f9e FOREIGN KEY (proposition_id) REFERENCES proposition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_eaa5610edb96f9e ON realisation (proposition_id)');
    }
}
