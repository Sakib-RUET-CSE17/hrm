<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420091729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE attendance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE attendance_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE designation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payroll_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payslip_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE salary_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON admin (username)');
        $this->addSql('CREATE TABLE attendance (id INT NOT NULL, employee_id INT NOT NULL, attendance_history_id INT DEFAULT NULL, entry_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, leave_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6DE30D918C03F15C ON attendance (employee_id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91D87CD94A ON attendance (attendance_history_id)');
        $this->addSql('COMMENT ON COLUMN attendance.entry_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN attendance.leave_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE attendance_history (id INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE designation (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, designation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, mobile VARCHAR(255) DEFAULT NULL, hire_date DATE DEFAULT NULL, nid VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, profile_picture_filename VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5D9F75A1FAC7D83F ON employee (designation_id)');
        $this->addSql('CREATE TABLE payroll (id INT NOT NULL, employee_id INT NOT NULL, payslip_history_id INT DEFAULT NULL, month INT DEFAULT NULL, year INT NOT NULL, status BOOLEAN NOT NULL, payment_status BOOLEAN DEFAULT NULL, gross_payable INT DEFAULT NULL, week INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_499FBCC68C03F15C ON payroll (employee_id)');
        $this->addSql('CREATE INDEX IDX_499FBCC652C140DA ON payroll (payslip_history_id)');
        $this->addSql('CREATE TABLE payslip_history (id INT NOT NULL, disbursement_type VARCHAR(255) NOT NULL, month INT DEFAULT NULL, week INT DEFAULT NULL, year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE salary (id INT NOT NULL, employee_id INT NOT NULL, amount INT DEFAULT NULL, disbursement_type VARCHAR(255) DEFAULT NULL, payment_method VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9413BB718C03F15C ON salary (employee_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D918C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91D87CD94A FOREIGN KEY (attendance_history_id) REFERENCES attendance_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1FAC7D83F FOREIGN KEY (designation_id) REFERENCES designation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payroll ADD CONSTRAINT FK_499FBCC68C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payroll ADD CONSTRAINT FK_499FBCC652C140DA FOREIGN KEY (payslip_history_id) REFERENCES payslip_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE salary ADD CONSTRAINT FK_9413BB718C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE attendance DROP CONSTRAINT FK_6DE30D91D87CD94A');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1FAC7D83F');
        $this->addSql('ALTER TABLE attendance DROP CONSTRAINT FK_6DE30D918C03F15C');
        $this->addSql('ALTER TABLE payroll DROP CONSTRAINT FK_499FBCC68C03F15C');
        $this->addSql('ALTER TABLE salary DROP CONSTRAINT FK_9413BB718C03F15C');
        $this->addSql('ALTER TABLE payroll DROP CONSTRAINT FK_499FBCC652C140DA');
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE attendance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE attendance_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE designation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE payroll_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE payslip_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE salary_id_seq CASCADE');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE attendance_history');
        $this->addSql('DROP TABLE designation');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE payroll');
        $this->addSql('DROP TABLE payslip_history');
        $this->addSql('DROP TABLE salary');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
