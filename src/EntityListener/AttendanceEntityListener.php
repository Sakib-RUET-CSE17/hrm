<?php

namespace App\EntityListener;

use App\Entity\Attendance;
use App\Repository\AttendanceRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;

class AttendanceEntityListener
{
    private AttendanceRepository $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function preUpdate(Attendance $attendance, LifecycleEventArgs $event)
    {
        $entryTime=$attendance->getEntryTime();
        $leaveTime=$attendance->getLeaveTime();
        if ($leaveTime<=$entryTime) {
            throw new Exception('Leave time must be greater than entryTime');
        }
    }

    // public function postPersist(RentRequest $rentRequest, LifecycleEventArgs $event){
    //     $this->bus->dispatch(new RentRequestMessage($rentRequest->getId()));
    // }
}
