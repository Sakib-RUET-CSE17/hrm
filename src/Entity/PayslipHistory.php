<?php

namespace App\Entity;

use App\Repository\PayslipHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayslipHistoryRepository::class)]
class PayslipHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $disbursementType;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $month;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $week;

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\OneToMany(mappedBy: 'payslipHistory', targetEntity: Payroll::class)]
    private $payrolls;

    public function __construct()
    {
        $this->payrolls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisbursementType(): ?string
    {
        return $this->disbursementType;
    }

    public function setDisbursementType(string $disbursementType): self
    {
        $this->disbursementType = $disbursementType;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(?int $month): self
    {
        $this->month = $month;

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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, Payroll>
     */
    public function getPayrolls(): Collection
    {
        return $this->payrolls;
    }

    public function addPayroll(Payroll $payroll): self
    {
        if (!$this->payrolls->contains($payroll)) {
            $this->payrolls[] = $payroll;
            $payroll->setPayslipHistory($this);
        }

        return $this;
    }

    public function removePayroll(Payroll $payroll): self
    {
        if ($this->payrolls->removeElement($payroll)) {
            // set the owning side to null (unless already changed)
            if ($payroll->getPayslipHistory() === $this) {
                $payroll->setPayslipHistory(null);
            }
        }

        return $this;
    }
}
