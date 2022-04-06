<?php

namespace App\Command;

use App\Entity\Payroll;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PaySlipGenerateCommand extends Command
{
    private $employeeRepository;
    private $entityManager;

    protected static $defaultName = 'app:payslip:generate';

    public function __construct(EmployeeRepository $employeeRepository, EntityManagerInterface $entityManager)
    {
        $this->employeeRepository = $employeeRepository;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Insert payslip to the database')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // if ($input->getOption('dry-run')) {
        $io->note('Dry mode enabled');

        $employees = $this->employeeRepository->findAll();
        $count = count($employees);
        $month = date('m');
        $year = date('Y');
        foreach ($employees as $employee) {
            $payroll = new Payroll();
            $payroll->setEmployee($employee)
                ->setMonth($month)
                ->setYear($year)
                ->setStatus(false)
                ->setPaymentStatus(false);
            $this->entityManager->persist($payroll);
            $this->entityManager->flush();
        }

        $io->success(sprintf('Inserted "%d" employees payslip.', $count));

        return 0;
    }
}
