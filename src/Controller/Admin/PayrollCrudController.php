<?php

namespace App\Controller\Admin;

use App\Entity\Payroll;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PayrollCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Payroll::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
