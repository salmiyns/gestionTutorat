<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507184527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE cours DROP CONSTRAINT fk_fdca8c9cdb96f9e');
        $this->addSql('DROP INDEX idx_fdca8c9cdb96f9e');
        $this->addSql('ALTER TABLE cours DROP proposition_id');
        $this->addSql('ALTER TABLE tuteur DROP CONSTRAINT fk_56412268db96f9e');
        $this->addSql('DROP INDEX idx_56412268db96f9e');
        $this->addSql('ALTER TABLE tuteur DROP proposition_id');
        $this->addSql('ALTER TABLE proposition ADD cours_id INT NOT NULL');
        $this->addSql('ALTER TABLE proposition ADD tuteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE proposition RENAME COLUMN deiscription TO description');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC3537ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC35386EC68D8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7CDC3537ECF78B0 ON proposition (cours_id)');
        $this->addSql('CREATE INDEX IDX_C7CDC35386EC68D8 ON proposition (tuteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE proposition DROP CONSTRAINT FK_C7CDC3537ECF78B0');
        $this->addSql('ALTER TABLE proposition DROP CONSTRAINT FK_C7CDC35386EC68D8');
        $this->addSql('DROP INDEX UNIQ_C7CDC3537ECF78B0');
        $this->addSql('DROP INDEX IDX_C7CDC35386EC68D8');
        $this->addSql('ALTER TABLE proposition DROP cours_id');
        $this->addSql('ALTER TABLE proposition DROP tuteur_id');
        $this->addSql('ALTER TABLE proposition RENAME COLUMN description TO deiscription');
        $this->addSql('ALTER TABLE cours ADD proposition_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT fk_fdca8c9cdb96f9e FOREIGN KEY (proposition_id) REFERENCES proposition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fdca8c9cdb96f9e ON cours (proposition_id)');
        $this->addSql('ALTER TABLE tuteur ADD proposition_id INT NOT NULL');
        $this->addSql('ALTER TABLE tuteur ADD CONSTRAINT fk_56412268db96f9e FOREIGN KEY (proposition_id) REFERENCES proposition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_56412268db96f9e ON tuteur (proposition_id)');
    }
}
