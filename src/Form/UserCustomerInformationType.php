<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\CustomerInformation;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCustomerInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customerInformation', CustomerInformationType::class, [
                'data_class' => CustomerInformation::class,
            ])
            ->add('user', RegistrationFormType::class, [
                'data_class' => User::class,
            ])
        ;
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}