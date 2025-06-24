<?php

namespace App\Controller\Admin;

use App\Entity\IceCream;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IceCreamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IceCream::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextField::new('special_ingredient'),
            TextField::new('image_name'),
            AssociationField::new('cone','id : cone')
            ->formatValue(function ($value) {
                return $value->getId(). ' : ' .$value->getTypeCone();
            }),
            AssociationField::new('toping','id : toping')
            ->formatValue(function ($value) {
                if ($value) {
                    return implode(' | ', $value->map(fn($toping) => $toping->getId(). ' : ' .$toping->getTypeToping())->toArray());
                }
            }),
        ];
    }
}
