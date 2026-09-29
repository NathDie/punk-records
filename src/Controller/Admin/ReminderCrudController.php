<?php

namespace App\Controller\Admin;

use App\Entity\Reminder;
use App\Enum\RecurrenceRule;
use App\Enum\Status;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReminderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reminder::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'reminder.controller.index')
            ->setPageTitle('new', 'reminder.controller.new')
            ->setPageTitle('edit', 'reminder.controller.edit')
            ->setPageTitle('detail', 'reminder.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('reminder.label.singular')
            ->setEntityLabelInPlural('reminder.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('title', 'reminder.form.title'),
            TextareaField::new('description', 'reminder.form.description')
                ->hideOnIndex()
                ->setNumOfRows(4),
            DateTimeField::new('remindAt', 'reminder.form.remind_at'),
            ChoiceField::new('status', 'reminder.form.status')
                ->setChoices(Status::cases())
                ->renderAsBadges(),
            DateField::new('snoozedUntil', 'reminder.form.snoozed_until'),
            ChoiceField::new('recurring', 'reminder.form.recurring')
                ->setChoices(RecurrenceRule::cases())
                ->renderAsBadges(),
        ];
    }
}
