<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\CustomerInformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('birthday', BirthdayType::class, [
                'widget' => 'single_text',
                'empty_data' => null,
                'required' => false,
            ])
            ->add('city', TextType::class)
            ->add('address', TextType::class)
            ->add('phoneNumber', TelType::class)
            ->add('zipCode', TextType::class)
        ;
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomerInformation::class,
        ]);
    }
}
