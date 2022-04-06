<?php

namespace App\EntityListener;

use App\Entity\Payroll;
use App\Repository\PayrollRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Exception;

class PayrollEntityListener
{
    private PayrollRepository $payrollRepository;

    public function __construct(PayrollRepository $payrollRepository)
    {
        $this->payrollRepository = $payrollRepository;
    }

    public function preUpdate(Payroll $payroll, LifecycleEventArgs $event)
    {
        $status = $payroll->getStatus();
        $paymentStatus = $payroll->getPaymentStatus();
        if (!$status && $paymentStatus) {
            throw new Exception('Must be approved before payment!');
        }
    }
}
