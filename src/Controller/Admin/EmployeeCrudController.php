<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextField::new('mobile');
        yield DateField::new('hireDate');
        yield TextField::new('mobile');
        if (Crud::PAGE_NEW !== $pageName && Crud::PAGE_EDIT !== $pageName) {
            yield AssociationField::new('salary');
        }
    }
}
