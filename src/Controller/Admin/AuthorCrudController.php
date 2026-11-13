<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AuthorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Author::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'book_author.controller.index')
            ->setPageTitle('new', 'book_author.controller.new')
            ->setPageTitle('edit', 'book_author.controller.edit')
            ->setPageTitle('detail', 'book_author.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('book_author.label.singular')
            ->setEntityLabelInPlural('book_author.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('name', 'book_author.form.name'),
        ];
    }
}
