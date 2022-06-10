<?php

namespace App\EntityListener;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class EmployeeEntityListener
{
    private $attendanceHistoryRepository;
    private $entityManager;

    public function __construct()
    {
    }

    public function prePersist(Employee $employee, LifecycleEventArgs $event)
    {
        $roles = $employee->getAdmin()->getRoles();
        $roles[] = 'ROLE_EMPLOYEE';
        $employee->getAdmin()->setRoles($roles);
    }
}
