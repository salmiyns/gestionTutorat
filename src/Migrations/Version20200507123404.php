<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507123404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE cours ADD demande_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C80E95E18 ON cours (demande_id)');
        $this->addSql('ALTER TABLE demande ADD tutore_id INT NOT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A55899F888 FOREIGN KEY (tutore_id) REFERENCES tutore (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2694D7A55899F888 ON demande (tutore_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9C80E95E18');
        $this->addSql('DROP INDEX IDX_FDCA8C9C80E95E18');
        $this->addSql('ALTER TABLE cours DROP demande_id');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A55899F888');
        $this->addSql('DROP INDEX IDX_2694D7A55899F888');
        $this->addSql('ALTER TABLE demande DROP tutore_id');
    }
}
