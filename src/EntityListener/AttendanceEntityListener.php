<?php

namespace App\EntityListener;

use App\Entity\Attendance;
use App\Entity\AttendanceHistory;
use App\Repository\AttendanceHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class AttendanceEntityListener
{
    private $attendanceHistoryRepository;
    private $entityManager;

    public function __construct(AttendanceHistoryRepository $attendanceHistoryRepository, EntityManagerInterface $entityManager)
    {
        $this->attendanceHistoryRepository = $attendanceHistoryRepository;
        $this->entityManager = $entityManager;
    }

    public function prePersist(Attendance $attendance, LifecycleEventArgs $event)
    {
        $entryTime = $attendance->getEntryTime()->format('Y-m-d');
        $entryDate = new \DateTime($entryTime);


        $attendanceHistory = $this->attendanceHistoryRepository->createQueryBuilder("a")
            ->andWhere('a.date=?0')
            ->setParameter(0, $entryDate)
            ->getQuery();
        // dump($rents);
        $attendanceHistory = $attendanceHistory->getResult();
        dump($attendanceHistory);

        if (isset($attendanceHistory[0])) {
            // $attendanceHistory[0]
            $attendance->setAttendanceHistory($attendanceHistory[0]);
        } else {
            $attendanceHistory = new AttendanceHistory();
            $attendanceHistory->setDate($entryDate);
            $attendance->setAttendanceHistory($attendanceHistory);
            $this->entityManager->persist($attendanceHistory);
            $this->entityManager->flush();
        }
        // die();
    }

    // public function preUpdate(Conference $conference, LifecycleEventArgs $event)
    // {
    //     $conference->computeSlug($this->slugger);
    // }
}
