<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614133705 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE "user" ADD is_active BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD firstname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD activated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP roles');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE "user" DROP date_of_birth');
        $this->addSql('ALTER TABLE "user" DROP profile_pic');
        $this->addSql('ALTER TABLE "user" DROP activation_code');
        $this->addSql('ALTER TABLE "user" DROP registration_date');
        $this->addSql('ALTER TABLE "user" DROP status');
        $this->addSql('ALTER TABLE "user" DROP telephone');
        $this->addSql('ALTER TABLE "user" DROP sexe');
        $this->addSql('ALTER TABLE "user" DROP adresse');
        $this->addSql('ALTER TABLE "user" DROP about');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(60)');
        $this->addSql('ALTER TABLE "user" ALTER password TYPE VARCHAR(64)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD date_of_birth DATE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD profile_pic VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD activation_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD registration_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD telephone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD sexe VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD about TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP is_active');
        $this->addSql('ALTER TABLE "user" DROP firstname');
        $this->addSql('ALTER TABLE "user" DROP token');
        $this->addSql('ALTER TABLE "user" DROP created_at');
        $this->addSql('ALTER TABLE "user" DROP updated_at');
        $this->addSql('ALTER TABLE "user" DROP activated_at');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE "user" ALTER password TYPE VARCHAR(255)');
    }
}
