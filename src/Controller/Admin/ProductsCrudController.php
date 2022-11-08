<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }


    public function configureFields(string $pageName): iterable
    {
       return [
           TextField::new('name', 'Produit'),  // 'name' comme on le trouve dans table
           SlugField::new('slug')->setTargetFieldName('name'),
           ImageField::new('illustration')
               ->setBasePath('uploads/')
               ->setUploadDir('/public/uploads')
               ->setUploadedFileNamePattern('[randomhash].[extension]')
               ->setRequired(false),
           TextField::new('subtitle'),
           TextareaField::new('description'),
           MoneyField::new('price')->setCurrency('DZD'),
           BooleanField::new('isBest', 'A la une'),
           AssociationField::new('category')
       ];
    }

}
