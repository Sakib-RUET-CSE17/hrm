<?php

namespace App\Entity;

use App\Repository\SalaryRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalaryRepository::class)]
class Salary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'salary', targetEntity: Employee::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $employee;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\GreaterThan(0)]
    private $amount;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $disbursementType;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $paymentMethod;

    public function __toString(): string
    {
        return $this->amount;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDisbursementType(): ?string
    {
        return $this->disbursementType;
    }

    public function setDisbursementType(?string $disbursementType): self
    {
        $this->disbursementType = $disbursementType;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}
