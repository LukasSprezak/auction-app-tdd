<?php
declare(strict_types=1);
namespace App\Controller\Admin;

use App\Entity\ProductOffer;
use App\Enum\StatusProductOfferEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class ProductOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductOffer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->onlyOnIndex(),
            Field::new('title'),
            TextAreaField::new('description')
                ->hideOnIndex(),
            MoneyField::new('price')
            ->setCurrency('EUR'),
            TextField::new('status')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['enum_class' => StatusProductOfferEnum::class]),
            Field::new('enabled'),
            AssociationField::new('owner'),
            DateTimeField::new('createdAt')
        ];
    }

}
