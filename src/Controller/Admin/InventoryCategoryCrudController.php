<?php

namespace App\Controller\Admin;

use App\Entity\InventoryCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InventoryCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InventoryCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'inventory_category.controller.index')
            ->setPageTitle('new', 'inventory_category.controller.new')
            ->setPageTitle('edit', 'inventory_category.controller.edit')
            ->setPageTitle('detail', 'inventory_category.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('inventory_category.label.singular')
            ->setEntityLabelInPlural('inventory_category.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('name', 'inventory_category.form.name'),
        ];
    }
}
