<?php

namespace App\Entity;

use App\Log\LogAware;
use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AttendanceRepository::class)]
class Attendance implements LogAware
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'attendances')]
    #[ORM\JoinColumn(nullable: false)]
    private $employee;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\GreaterThanOrEqual("today +9 hours")]
    private $entryTime;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Assert\Expression(
        "this.getLeaveTime() > this.getEntryTime() or value == null",
        message: "Leave time must be greater than entry Time"
    )]
    private $leaveTime;

    #[ORM\ManyToOne(targetEntity: AttendanceHistory::class, inversedBy: 'attendances')]
    private $attendanceHistory;

    public function __toString(): string
    {
        return $this->employee;
    }

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

    public function getAttendanceHistory(): ?AttendanceHistory
    {
        return $this->attendanceHistory;
    }

    public function setAttendanceHistory(?AttendanceHistory $attendanceHistory): self
    {
        $this->attendanceHistory = $attendanceHistory;

        return $this;
    }
}
