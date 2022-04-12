<?php

namespace App\Controller\Admin;

use App\Entity\PayslipHistory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PayslipHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PayslipHistory::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('disbursementType');
        yield NumberField::new('week');
        yield NumberField::new('month');
        yield NumberField::new('year');
        yield AssociationField::new('payrolls')->setFormTypeOption("by_reference", false);
    }

    // public function configureActions(Actions $actions): Actions
    // {
    //     $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    //     return $actions;
    // }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud->overrideTemplate('crud/detail', 'detail.html.twig');
    // }
}
