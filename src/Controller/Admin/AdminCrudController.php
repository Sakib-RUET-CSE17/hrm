<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdminCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_EDIT !== $pageName && Crud::PAGE_NEW !== $pageName) {
            yield NumberField::new('id');
        }
        yield TextField::new('firebaseUid');
        yield TextField::new('username');
        yield AssociationField::new('employee');
        yield ArrayField::new('roles');
    }
}
