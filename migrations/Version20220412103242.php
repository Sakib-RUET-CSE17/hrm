<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412103242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE payslip_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE payslip_history (id INT NOT NULL, disbursement_type VARCHAR(255) NOT NULL, month INT DEFAULT NULL, week INT DEFAULT NULL, year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE payroll ADD payslip_history_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payroll ADD CONSTRAINT FK_499FBCC652C140DA FOREIGN KEY (payslip_history_id) REFERENCES payslip_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_499FBCC652C140DA ON payroll (payslip_history_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE payroll DROP CONSTRAINT FK_499FBCC652C140DA');
        $this->addSql('DROP SEQUENCE payslip_history_id_seq CASCADE');
        $this->addSql('DROP TABLE payslip_history');
        $this->addSql('DROP INDEX IDX_499FBCC652C140DA');
        $this->addSql('ALTER TABLE payroll DROP payslip_history_id');
    }
}
