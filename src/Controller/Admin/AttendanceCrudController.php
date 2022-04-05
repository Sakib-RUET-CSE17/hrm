<?php

namespace App\Controller\Admin;

use App\Entity\Attendance;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class AttendanceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Attendance::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Employee Attendance')
            ->setEntityLabelInPlural('Employee Attendances')
            ->setSearchFields(['employee', 'entryTime', 'leaveTime'])
            ->setDefaultSort(['entryTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('employee'));
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('employee');
        // yield TextField::new('author');
        // yield EmailField::new('email');
        // yield TextareaField::new('text')
        //     ->hideOnIndex();
        // yield ImageField::new('photoFilename')
        //     ->setBasePath('/uploads/photos')
        //     ->setLabel('Photo')
        //     ->onlyOnIndex();
        // yield TextField::new('state');

        $entryTime = DateTimeField::new('entryTime')->setFormTypeOptions([
            'html5' => true,
            'years' => range(date('Y'), date('Y') + 5),
            'widget' => 'single_text',
        ]);
        if (Crud::PAGE_EDIT === $pageName) {
            yield $entryTime->setFormTypeOption('disabled', true);
        } else {
            yield $entryTime;
        }
    }
    
}
