<?php

namespace App\Entity;

use App\Log\LogAware;
use App\Repository\PayrollRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PropertyAccess\PropertyPath;

#[ORM\Entity(repositoryClass: PayrollRepository::class)]
class Payroll implements LogAware
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'payrolls')]
    #[ORM\JoinColumn(nullable: false)]
    private $employee;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $month;

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'boolean')]
    private $status;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Assert\Expression(
        "this.getStatus() == this.getPaymentStatus() or value == false",
        message: "Should be approved first",
    )]
    private $paymentStatus;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $grossPayable;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $week;

    #[ORM\ManyToOne(targetEntity: PayslipHistory::class, inversedBy: 'payrolls')]
    private $payslipHistory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->employee;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentStatus(): ?bool
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(bool $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    public function getGrossPayable(): ?int
    {
        return $this->grossPayable;
    }

    public function setGrossPayable(?int $grossPayable): self
    {
        $this->grossPayable = $grossPayable;

        return $this;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(?int $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getPayslipHistory(): ?PayslipHistory
    {
        return $this->payslipHistory;
    }

    public function setPayslipHistory(?PayslipHistory $payslipHistory): self
    {
        $this->payslipHistory = $payslipHistory;

        return $this;
    }
}
