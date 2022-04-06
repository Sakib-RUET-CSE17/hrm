<?php

namespace App\Entity;

use App\Repository\PayrollRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayrollRepository::class)]
class Payroll
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'payrolls')]
    #[ORM\JoinColumn(nullable: false)]
    private $employee;

    #[ORM\Column(type: 'integer')]
    private $month;

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'boolean')]
    private $status;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $paymentStatus;

    public function getId(): ?int
    {
        return $this->id;
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
}
