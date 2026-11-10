<?php

namespace App\Controller\Admin;

use App\Entity\MaintenanceLog;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class MaintenanceLogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaintenanceLog::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'maintenance_log.controller.index')
            ->setPageTitle('new', 'maintenance_log.controller.new')
            ->setPageTitle('edit', 'maintenance_log.controller.edit')
            ->setPageTitle('detail', 'maintenance_log.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('maintenance_log.label.singular')
            ->setEntityLabelInPlural('maintenance_log.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex()
                ->setColumns(12),
            DateField::new('doneAt', 'maintenance_log.form.done_at'),
            TextareaField::new('note', 'maintenance_log.form.note')
                ->hideOnIndex()
                ->setColumns(12)
                ->setNumOfRows(4),
        ];
    }
}
