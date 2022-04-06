<?php

namespace App\Controller\Admin;

use App\Entity\Payroll;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
        yield NumberField::new('month');
        yield NumberField::new('year');
        if (Crud::PAGE_EDIT === $pageName|| Crud::PAGE_NEW !== $pageName) {
            yield TextField::new('employee.getSalary');
        }
        yield ChoiceField::new('status')->setChoices([
            'Generated' => 'false',
            'Approved' => 'true',
        ]);
    }
}
