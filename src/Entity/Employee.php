<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mobile;

    #[ORM\Column(type: 'date', nullable: true)]
    private $hireDate;

    #[ORM\OneToOne(mappedBy: 'employee', targetEntity: Salary::class, cascade: ['persist', 'remove'])]
    private $salary;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: Attendance::class, orphanRemoval: true)]
    private $attendances;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: Payroll::class, orphanRemoval: true)]
    private $payrolls;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nid;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\LessThan("today")]
    private $birthDate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gender;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $profilePictureFilename;

    #[ORM\ManyToOne(targetEntity: Designation::class, inversedBy: 'employees')]
    private $designation;

    #[ORM\OneToOne(inversedBy: 'employee', targetEntity: Admin::class, cascade: ['persist', 'remove'])]
    private $admin;

    public function __construct()
    {
        $this->attendances = new ArrayCollection();
        $this->payrolls = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getHireDate(): ?\DateTimeInterface
    {
        return $this->hireDate;
    }

    public function setHireDate(?\DateTimeInterface $hireDate): self
    {
        $this->hireDate = $hireDate;

        return $this;
    }

    public function getSalary(): ?Salary
    {
        return $this->salary;
    }

    public function setSalary(Salary $salary): self
    {
        // set the owning side of the relation if necessary
        if ($salary->getEmployee() !== $this) {
            $salary->setEmployee($this);
        }

        $this->salary = $salary;

        return $this;
    }

    /**
     * @return Collection<int, Attendance>
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances[] = $attendance;
            $attendance->setEmployee($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getEmployee() === $this) {
                $attendance->setEmployee(null);
            }
        }

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
            $payroll->setEmployee($this);
        }

        return $this;
    }

    public function removePayroll(Payroll $payroll): self
    {
        if ($this->payrolls->removeElement($payroll)) {
            // set the owning side to null (unless already changed)
            if ($payroll->getEmployee() === $this) {
                $payroll->setEmployee(null);
            }
        }

        return $this;
    }

    public function getNid(): ?string
    {
        return $this->nid;
    }

    public function setNid(?string $nid): self
    {
        $this->nid = $nid;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getProfilePictureFilename(): ?string
    {
        return $this->profilePictureFilename;
    }

    public function setProfilePictureFilename(?string $profilePictureFilename): self
    {
        $this->profilePictureFilename = $profilePictureFilename;

        return $this;
    }

    public function getDesignation(): ?Designation
    {
        return $this->designation;
    }

    public function setDesignation(?Designation $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
