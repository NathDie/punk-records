<?php

namespace App\Controller\Admin;

use App\Entity\BookCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BookCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'book_category.controller.index')
            ->setPageTitle('new', 'book_category.controller.new')
            ->setPageTitle('edit', 'book_category.controller.edit')
            ->setPageTitle('detail', 'book_category.controller.detail')
            ->setFormThemes(
                [
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            )
            ->setEntityLabelInSingular('book_category.label.singular')
            ->setEntityLabelInPlural('book_category.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('crud.tab.general')
                ->collapsible(),
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('name', 'book_category.form.name'),
        ];
    }
}
