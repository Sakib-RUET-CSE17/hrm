<?php

namespace App\Controller\Admin;

use App\Entity\AttendanceHistory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class AttendanceHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AttendanceHistory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateField::new('date');
        yield AssociationField::new('attendances')->setFormTypeOption("by_reference", false);
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->overrideTemplate('crud/detail', 'admin/attendanceHistory/detail.html.twig');
    }
}
