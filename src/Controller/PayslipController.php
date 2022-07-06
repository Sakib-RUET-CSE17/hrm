<?php

namespace App\Controller;

use App\Entity\Admin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayslipController extends AbstractController
{


    #[IsGranted('ROLE_EMPLOYEE')]
    #[Route('/payslip', name: 'app_payslip')]
    public function index(): Response
    {
        /** @var Admin */
        $user = $this->getUser();
        $employee = $user->getEmployee();
        $payrolls = $employee->getPayrolls();
        $payrollsSorted = $payrolls->toArray();

        usort($payrollsSorted, function ($payroll1, $payroll2) {
            // dd($payroll1, $payroll2);
            if ($payroll1->getWeek() != null) {
                return $payroll1->getWeek() > $payroll2->getWeek();
            }
            return $payroll1->getMonth() > $payroll2->getMonth();
        });

        return $this->render('payslip/index.html.twig', [
            'payrolls' => $payrollsSorted,
        ]);
    }
}
