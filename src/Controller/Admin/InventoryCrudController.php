<?php

namespace App\Controller\Admin;

use App\Entity\Inventory;
use App\Enum\EquipmentStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InventoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Inventory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'inventory.controller.index')
            ->setPageTitle('new', 'inventory.controller.new')
            ->setPageTitle('edit', 'inventory.controller.edit')
            ->setPageTitle('detail', 'inventory.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('inventory.label.singular')
            ->setEntityLabelInPlural('inventory.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('name', 'inventory.form.name'),
            TextareaField::new('description', 'inventory.form.description')
                ->hideOnIndex()
                ->setNumOfRows(4),
            NumberField::new('quantity', 'inventory.form.quantity'),
            DateField::new('purchaseDate', 'inventory.form.purchase_date'),
            MoneyField::new('purchasePrice', 'inventory.form.purchase_price')
                ->setCurrency('EUR')
                ->setStoredAsCents(false),
            DateField::new('warrantyExpiresAt', 'inventory.form.warranty_expires_at'),
            ChoiceField::new('equipmentStatus', 'inventory.form.equipment_status')
                ->setChoices(EquipmentStatus::cases()),
            AssociationField::new('usedBy', 'inventory.form.used_by'),
        ];
    }
}
