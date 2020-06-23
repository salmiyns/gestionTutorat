<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200616025349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD telephone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD about TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD activated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD is_verified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP activation_token');
        $this->addSql('ALTER TABLE "user" DROP reset_token');
        $this->addSql('ALTER TABLE "user" DROP firstname');
        $this->addSql('ALTER TABLE "user" DROP lastname');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN date_naissance TO date_of_birth');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ADD activation_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD reset_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD firstname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD lastname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE "user" DROP telephone');
        $this->addSql('ALTER TABLE "user" DROP adresse');
        $this->addSql('ALTER TABLE "user" DROP about');
        $this->addSql('ALTER TABLE "user" DROP token');
        $this->addSql('ALTER TABLE "user" DROP activated_at');
        $this->addSql('ALTER TABLE "user" DROP is_verified');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN date_of_birth TO date_naissance');
    }
}
