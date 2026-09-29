<?php

namespace App\Controller\Admin;

use App\Entity\Maintenance;
use App\Enum\RecurrenceRule;
use App\Enum\Status;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MaintenanceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Maintenance::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'maintenance.controller.index')
            ->setPageTitle('new', 'maintenance.controller.new')
            ->setPageTitle('edit', 'maintenance.controller.edit')
            ->setPageTitle('detail', 'maintenance.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('maintenance.label.singular')
            ->setEntityLabelInPlural('maintenance.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('title', 'maintenance.form.title'),
            TextareaField::new('description', 'maintenance.form.description')
                ->hideOnIndex()
                ->setNumOfRows(4),
            DateField::new('lastDoneAt', 'maintenance.form.last_done_at'),
            DateField::new('nextDueAt', 'maintenance.form.next_due_at'),
            ChoiceField::new('status', 'maintenance.form.status')
                ->setChoices(Status::cases())
                ->renderAsBadges(),
            ChoiceField::new('frequency', 'maintenance.form.frequency')
                ->setChoices(RecurrenceRule::cases())
                ->renderAsBadges(),
        ];
    }
}
