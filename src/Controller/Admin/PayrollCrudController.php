<?php

namespace App\Controller\Admin;

use App\Entity\Payroll;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PayrollCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Payroll::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('employee');
        yield ChoiceField::new('month')
            ->setChoices([
                'January' => 1,
                'February' => 2,
                'March' => 3,
                'April' => 4,
                'May' => 5,
                'June' => 6,
                'July' => 7,
                'August' => 8,
                'September' => 9,
                'October' => 10,
                'November' => 11,
                'December' => 12,
            ]);
        yield 'year';
        if (Crud::PAGE_EDIT !== $pageName && Crud::PAGE_NEW !== $pageName) {
            yield TextField::new('employee.getSalary');
        }
        yield BooleanField::new('status')->setLabel('Approved');
        yield BooleanField::new('paymentStatus')->setLabel('Paid');
    }
}
