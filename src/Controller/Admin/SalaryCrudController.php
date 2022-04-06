<?php

namespace App\Controller\Admin;

use App\Entity\Salary;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SalaryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Salary::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('employee');
        yield NumberField::new('amount');
        yield ChoiceField::new('disbursementType')
            ->setChoices([
                'Monthly' => 'monthly',
                'Weekly' => 'weekly',
            ]);
        yield ChoiceField::new('paymentMethod')->setChoices([
            'Cash' => 'cash',
            'Bkash' => 'bKash',
            'Rocket' => 'rocket',
            'Check' => 'check',
        ]);
    }
}
