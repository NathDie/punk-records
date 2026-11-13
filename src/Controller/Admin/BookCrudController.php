<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'book.controller.index')
            ->setPageTitle('new', 'book.controller.new')
            ->setPageTitle('edit', 'book.controller.edit')
            ->setPageTitle('detail', 'book.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('book.label.singular')
            ->setEntityLabelInPlural('book.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('title', 'book.form.title'),
            TextareaField::new('synopsis', 'book.form.synopsis')
                ->onlyOnForms(),
            DateField::new('publishedAt', 'book.form.published_at'),
            BooleanField::new('reading', 'book.form.reading'),
            AssociationField::new('author', 'book.form.author'),
            AssociationField::new('categories', 'book.form.categories'),
        ];
    }
}
