<?php

namespace App\Controller\Admin;

use App\Entity\Designation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DesignationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Designation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
    }
    
}
