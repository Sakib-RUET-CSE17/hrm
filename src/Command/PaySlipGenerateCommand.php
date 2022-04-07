<?php

namespace App\Command;

use App\Entity\Payroll;
use App\Repository\EmployeeRepository;
use App\Repository\PayrollRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PaySlipGenerateCommand extends Command
{
    private $employeeRepository;
    private $payrollRepository;
    private $entityManager;

    protected static $defaultName = 'app:payslip:generate';

    public function __construct(EmployeeRepository $employeeRepository, EntityManagerInterface $entityManager, PayrollRepository $payrollRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->payrollRepository = $payrollRepository;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Insert payslip to the database')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
            ->addArgument('month', InputArgument::OPTIONAL, 'Which month?')
            ->addArgument('year', InputArgument::OPTIONAL, 'Which year?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // if ($input->getOption('dry-run')) {
        $io->note('Dry mode enabled');

        $payrolls = $this->payrollRepository->findAll();
        $month = $input->getArgument('month');
        if (!$month) {
            $month = date('m');
        }
        $year = $input->getArgument('year');
        if (!$year) {
            $year = date('Y');
        }
        if (isset($payrolls[0])) {
            foreach ($payrolls as $payroll) {
                if ($payroll->getMonth() == $month && $payroll->getYear() == $year) {
                    $io->error(sprintf("Already Generated for month %d and year %d!\n
                    Inserted 0 employees payslip.", $month, $year));
                    return 0;
                }
            } 
        }

        $employees = $this->employeeRepository->findAll();
        $count = count($employees);

        foreach ($employees as $employee) {
            $payroll = new Payroll();
            $payroll->setEmployee($employee)
                ->setMonth($month)
                ->setYear($year)
                ->setGrossPayable($employee->getSalary()->getAmount())
                ->setStatus(false)
                ->setPaymentStatus(false);
            $this->entityManager->persist($payroll);
            $this->entityManager->flush();
        }

        $io->success(sprintf('Inserted "%d" employees payslip.', $count));

        return 0;
    }
}
