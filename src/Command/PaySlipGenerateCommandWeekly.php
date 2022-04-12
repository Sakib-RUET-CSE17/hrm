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

class PaySlipGenerateCommandWeekly extends Command
{
    private $salaryRepository;
    private $payslipHistoryRepository;
    // private $payrollRepository;
    private $entityManager;

    protected static $defaultName = 'app:payslip:generateWeek';

    public function __construct(PayslipHistoryRepository $payslipHistoryRepository, SalaryRepository $salaryRepository, EntityManagerInterface $entityManager)
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
            ->addArgument('week', InputArgument::OPTIONAL, 'Which week?')
            ->addArgument('year', InputArgument::OPTIONAL, 'Which year?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // if ($input->getOption('dry-run')) {
        // $io->note('Dry mode enabled');
        $week = $input->getArgument('week');
        if (!$week) {
            $week = date('W');
        }
        $year = $input->getArgument('year');
        if (!$year) {
            $year = date('Y');
        }
        $payslipHistory = $this->payslipHistoryRepository->findBy(['disbursementType' => 'weekly', 'week' => $week, 'year' => $year]);
        dump($payslipHistory);
        if (isset($payslipHistory[0])) {
            $io->error(sprintf("Already Generated for week %d and year %d!\n
                    Inserted 0 employees payslip.", $week, $year));
            return 0;
        }

        $salaries = $this->salaryRepository->findBy(['disbursementType' => 'weekly']);
        $count = count($salaries);
        $payslipHistory = new PayslipHistory();
        $payslipHistory->setDisbursementType('weekly')
            ->setWeek($week)
            ->setYear($year);
        $this->entityManager->persist($payslipHistory);

        foreach ($salaries as $salary) {
            $employee = $salary->getEmployee();
            $payroll = new Payroll();

            $payroll->setEmployee($employee)
                ->setWeek($week)
                ->setYear($year)
                ->setGrossPayable($salary->getAmount())
                ->setStatus(false)
                ->setPaymentStatus(false)
                ->setPayslipHistory($payslipHistory);

            $this->entityManager->persist($payroll);
            $this->entityManager->flush();

            $this->entityManager->persist($payslipHistory);
            // $this->entityManager->flush();
        }

        // $this->entityManager->flush();
        $io->success(sprintf('Inserted "%d" employees payslip.', $count));

        return 0;
    }
}
