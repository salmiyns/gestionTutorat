<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507220944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE seance ADD durée VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE seance DROP cours');
        $this->addSql('ALTER TABLE seance DROP date');
        $this->addSql('ALTER TABLE seance DROP tuteur');
        $this->addSql('ALTER TABLE seance RENAME COLUMN classe TO titre');
        $this->addSql('ALTER TABLE seance RENAME COLUMN objectif TO description');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE seance ADD cours INT NOT NULL');
        $this->addSql('ALTER TABLE seance ADD date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE seance ADD tuteur INT NOT NULL');
        $this->addSql('ALTER TABLE seance DROP durée');
        $this->addSql('ALTER TABLE seance RENAME COLUMN titre TO classe');
        $this->addSql('ALTER TABLE seance RENAME COLUMN description TO objectif');
    }
}
