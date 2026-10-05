<?php

namespace App\Controller\Admin;

use App\Entity\Monitoring;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MonitoringCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Monitoring::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'monitoring.controller.index')
            ->setPageTitle('new', 'monitoring.controller.new')
            ->setPageTitle('edit', 'monitoring.controller.edit')
            ->setPageTitle('detail', 'monitoring.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('monitoring.label.singular')
            ->setEntityLabelInPlural('monitoring.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('name', 'monitoring.form.name'),
            TextField::new('link', 'monitoring.form.link'),
            BooleanField::new('active', 'monitoring.form.active'),
        ];
    }
}
