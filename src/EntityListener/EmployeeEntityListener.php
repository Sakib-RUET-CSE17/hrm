<?php

namespace App\EntityListener;

use App\Entity\Employee;
use App\Helper\BulkSmsBd;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class EmployeeEntityListener
{
    private $attendanceHistoryRepository;
    private $entityManager;

    public function __construct(private BulkSmsBd $bulkSmsBd)
    {
    }

    public function prePersist(Employee $employee, LifecycleEventArgs $event)
    {
        $roles = $employee->getAdmin()?->getRoles();
        $roles[] = 'ROLE_EMPLOYEE';
        $employee->getAdmin()?->setRoles($roles);

        $mobile = $employee->getMobile();
        $smsResult = $this->bulkSmsBd->sendSms($mobile, 'I love u');
        // dd($smsResult);
    }
}
