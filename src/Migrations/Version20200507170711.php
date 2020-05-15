<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507170711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE tutore DROP CONSTRAINT fk_9744b4beddeab1a3');
        $this->addSql('ALTER TABLE tutore DROP CONSTRAINT fk_9744b4bec5f87c54');
        $this->addSql('DROP INDEX uniq_9744b4bec5f87c54');
        $this->addSql('DROP INDEX uniq_9744b4beddeab1a3');
        $this->addSql('ALTER TABLE tutore DROP etudiant_id');
        $this->addSql('ALTER TABLE tutore DROP id_etudiant_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tutore ADD etudiant_id INT NOT NULL');
        $this->addSql('ALTER TABLE tutore ADD id_etudiant_id INT NOT NULL');
        $this->addSql('ALTER TABLE tutore ADD CONSTRAINT fk_9744b4beddeab1a3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tutore ADD CONSTRAINT fk_9744b4bec5f87c54 FOREIGN KEY (id_etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_9744b4bec5f87c54 ON tutore (id_etudiant_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_9744b4beddeab1a3 ON tutore (etudiant_id)');
    }
}
