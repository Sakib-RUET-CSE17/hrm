<?php

namespace App\Command;

use App\Entity\Payroll;
use App\Entity\PayslipHistory;
use App\Repository\EmployeeRepository;
use App\Repository\PayrollRepository;
use App\Repository\PayslipHistoryRepository;
use App\Repository\SalaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PaySlipGenerateCommandMonthly extends Command
{
    // private $employeeRepository;
    private $salaryRepository;
    private $payslipHistoryRepository;
    // private $payrollRepository;
    private $entityManager;

    protected static $defaultName = 'app:payslip:generateMonth';

    public function __construct(SalaryRepository $salaryRepository, EntityManagerInterface $entityManager, PayslipHistoryRepository $payslipHistoryRepository)
    {
        $this->payslipHistoryRepository = $payslipHistoryRepository;
        $this->salaryRepository = $salaryRepository;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Insert payslip to the database')
            // ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
            ->addArgument('month', InputArgument::OPTIONAL, 'Which month?')
            ->addArgument('year', InputArgument::OPTIONAL, 'Which year?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // if ($input->getOption('dry-run')) {
        // $io->note('Dry mode enabled');
        $month = $input->getArgument('month');
        if (!$month) {
            $month = date('m');
        }
        $year = $input->getArgument('year');
        if (!$year) {
            $year = date('Y');
        }
        $payslipHistory = $this->payslipHistoryRepository->findBy(['disbursementType' => 'monthly', 'month' => $month, 'year' => $year]);
        if (isset($payslipHistory[0])) {
            $io->error(sprintf("Already Generated for month %d and year %d!\n
                    Inserted 0 employees payslip.", $month, $year));
            return 0;
        }

        $salaries = $this->salaryRepository->findBy(['disbursementType' => 'monthly']);
        $count = count($salaries);
        $payslipHistory = new PayslipHistory();
        $payslipHistory->setDisbursementType('monthly')
            ->setMonth($month)
            ->setYear($year);
        $this->entityManager->persist($payslipHistory);

        foreach ($salaries as $salary) {
            $employee = $salary->getEmployee();
            $payroll = new Payroll();

            $payroll->setEmployee($employee)
                ->setMonth($month)
                ->setYear($year)
                ->setGrossPayable($salary->getAmount())
                ->setStatus(false)
                ->setPaymentStatus(false)
                ->setPayslipHistory($payslipHistory);
            $this->entityManager->persist($payroll);
            $this->entityManager->flush();

            $this->entityManager->persist($payslipHistory);
        }

        $io->success(sprintf('Inserted "%d" employees payslip.', $count));

        return 0;
    }
}
