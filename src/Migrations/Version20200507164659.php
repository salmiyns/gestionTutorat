<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507164659 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE tuteur RENAME COLUMN id_etudiant TO id_etudiant_id');
        $this->addSql('ALTER TABLE tuteur ADD CONSTRAINT FK_56412268C5F87C54 FOREIGN KEY (id_etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_56412268C5F87C54 ON tuteur (id_etudiant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tuteur DROP CONSTRAINT FK_56412268C5F87C54');
        $this->addSql('DROP INDEX UNIQ_56412268C5F87C54');
        $this->addSql('ALTER TABLE tuteur RENAME COLUMN id_etudiant_id TO id_etudiant');
    }
}
