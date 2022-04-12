<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410182407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE attendance_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE attendance_history (id INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE attendance ADD attendance_history_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91D87CD94A FOREIGN KEY (attendance_history_id) REFERENCES attendance_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6DE30D91D87CD94A ON attendance (attendance_history_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE attendance DROP CONSTRAINT FK_6DE30D91D87CD94A');
        $this->addSql('DROP SEQUENCE attendance_history_id_seq CASCADE');
        $this->addSql('DROP TABLE attendance_history');
        $this->addSql('DROP INDEX IDX_6DE30D91D87CD94A');
        $this->addSql('ALTER TABLE attendance DROP attendance_history_id');
    }
}
