<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407035415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP profile_picture_filename');
        $this->addSql('ALTER TABLE employee DROP cv_filename');
        $this->addSql('ALTER TABLE payroll ADD gross_payable INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE payroll DROP gross_payable');
        $this->addSql('ALTER TABLE employee ADD profile_picture_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD cv_filename VARCHAR(255) DEFAULT NULL');
    }
}
