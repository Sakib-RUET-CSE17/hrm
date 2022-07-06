<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\PayrollRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayslipController extends AbstractController
{
    #[IsGranted('ROLE_EMPLOYEE')]
    #[Route('/payslip', name: 'app_payslip')]
    public function index(
        PayrollRepository $payrollRepository
    ): Response {
        /** @var Admin */
        $user = $this->getUser();
        $employee = $user->getEmployee();
        $payrolls = $employee->getPayrolls();

        return $this->render('payslip/index.html.twig', [
            'payrolls' => $payrollsSorted,
        ]);
    }
}
