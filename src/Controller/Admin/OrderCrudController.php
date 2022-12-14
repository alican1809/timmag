<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureActions(Actions $actions): Actions
    {
            return $actions
        ->add('index','detail');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            //DateTimeField::new('createdAt', 'Passée le'),
            TextField::new('user.fullname', 'Utilisateur'),
            TextField::new('user.email', 'Email'),
            MoneyField::new('total', 'Total produit')->setCurrency('EUR'),
            BooleanField::new('isPaid')
        ];
    }
    
}
