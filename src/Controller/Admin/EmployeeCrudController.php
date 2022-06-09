<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
        yield AssociationField::new('admin','User');

        yield ImageField::new('profilePictureFilename')
            ->setBasePath('/images')
            ->setUploadDir('public/images')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setLabel('Profile Picture');

        yield TextField::new('mobile');
        yield TextField::new('nid')->setLabel('NID');
        yield 'birthDate';
        yield ChoiceField::new('gender')->setChoices(['Male' => 'M', 'Female' => 'F']);
        yield DateField::new('hireDate');
        yield AssociationField::new('designation');
        yield AssociationField::new('salary')->onlyOnIndex();
    }
}
