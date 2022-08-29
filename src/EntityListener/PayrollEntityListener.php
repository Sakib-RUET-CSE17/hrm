<?php

namespace App\EntityListener;

use App\Entity\Employee;
use App\Entity\Payroll;
use App\Helper\BulkSmsBd;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PayrollEntityListener
{
    public function __construct(private BulkSmsBd $bulkSmsBd)
    {
    }

    public function postUpdate(Payroll $payroll, LifecycleEventArgs $event)
    {
        // dd($payroll);
        $employee = $payroll->getEmployee();
        $name = $employee->getName();
        $month = $payroll->getMonth();
        $week = $payroll->getWeek();
        $year = $payroll->getYear();
        $amount = $payroll->getGrossPayable();
        $paymentMethod = $employee->getSalary()->getPaymentMethod();

        $mobile = $payroll->getEmployee()->getMobile();
        $message = 'Dear ' . $name . ', your salary of ';
        if ($month) {
            $message .= 'month ' . $month;
        } else {
            $message .= 'week ' . $week;
        }
        $date = new \DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date = $date->format('d-m-Y H:i:s');
        // dd($date);
        $message .= '/' . $year . ' has been paid successfully on ' . $date . '. Amount: ' . $amount . ', Payment Method: ' . $paymentMethod;
        // dd($message);
        if ($payroll->getPaymentStatus()) {
            $smsResult = $this->bulkSmsBd->sendSms($mobile, $message);
        }
        // dd($smsResult);
    }
}
