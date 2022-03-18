<?php
declare(strict_types=1);
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class UserCrudController extends AbstractCrudController
{
    private const DIRECTORY_LOGO = 'upload/logo/';

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = [
            'ROLE_USER',
            'ROLE_ADMIN'
        ];

        return [
            IdField::new('id')
                ->onlyOnIndex(),
            EmailField::new('email'),
            ChoiceField::new('roles')
                ->setChoices(array_combine($roles, $roles))
                ->allowMultipleChoices()
                ->renderExpanded()
                ->onlyOnForms(),
            TextField::new('username'),
            AvatarField::new('logo')
                ->formatValue(static function($value, User $user) {
                    return self::DIRECTORY_LOGO . $user->getLogo();
                })
                ->hideOnForm()
                ->setLabel('Logo'),
            ImageField::new('logo')
                ->setBasePath('upload/logo')
                ->setUploadDir('public/upload/logo')
                ->onlyOnForms(),
            BooleanField::new('enabled')
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(BooleanFilter::new('enabled')
                ->setFormTypeOption('expanded', false))
            ->add(TextFilter::new('email'))
        ;
    }
}
