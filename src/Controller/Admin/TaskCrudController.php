<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Enum\Priority;
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

class TaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'task.controller.index')
            ->setPageTitle('new', 'task.controller.new')
            ->setPageTitle('edit', 'task.controller.edit')
            ->setPageTitle('detail', 'task.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('task.label.singular')
            ->setEntityLabelInPlural('task.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('title', 'task.form.title'),
            TextareaField::new('description', 'task.form.description')
                ->hideOnIndex()
                ->setNumOfRows(4),
            ChoiceField::new('status', 'task.form.status')
                ->setChoices(Status::cases())
                ->renderAsBadges(),
            ChoiceField::new('priority', 'task.form.priority')
                ->setChoices(Priority::cases()),
            DateTimeField::new('dueDate', 'task.form.due_date'),
            DateField::new('completeAt', 'task.form.complete_at')
        ];
    }
}
