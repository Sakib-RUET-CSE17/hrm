<?php

namespace App\Entity;

use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceRepository::class)]
class Attendance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'attendances')]
    #[ORM\JoinColumn(nullable: false)]
    private $employee;

    #[ORM\Column(type: 'datetime_immutable')]
    private $entryTime;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $leaveTime;

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

    public function getEntryTime(): ?\DateTimeImmutable
    {
        return $this->entryTime;
    }

    public function setEntryTime(\DateTimeImmutable $entryTime): self
    {
        $this->entryTime = $entryTime;

        return $this;
    }

    public function getLeaveTime(): ?\DateTimeImmutable
    {
        return $this->leaveTime;
    }

    public function setLeaveTime(\DateTimeImmutable $leaveTime): self
    {
        $this->leaveTime = $leaveTime;

        return $this;
    }
}
