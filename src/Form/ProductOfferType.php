<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\ProductOffer;
use App\Enum\CompanyOrIndividualEnum;
use App\Enum\ProductBillingEnum;
use App\Enum\StateProductEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ProductOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a title.']),
                    new Length([
                        'max' => 120,
                        'maxMessage' => 'The title can be up to 120 characters long.'
                    ])
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a description.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'The description can be up to 255 characters long.'
                    ])
                ]
            ])
            ->add("price", NumberType::class, [
                "label" => "Price",
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a price.']),
                    new GreaterThan(0)
                ]
            ])
            ->add('stateOfProduct', EnumType::class, [
                'required' => true,
                'class' => StateProductEnum::class,
                'expanded' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please select the radio button.']),
                ]
            ])
            ->add('enabled', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom'
                ]
            ])
            ->add('companyOrIndividual', EnumType::class, [
                'required' => true,
                'class' => CompanyOrIndividualEnum::class,
                'expanded' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please select the radio button.']),
                ]
            ])
            ->add('negotiablePrice', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom'
                ]
            ])
            ->add('productBilling', EnumType::class, [
                'required' => true,
                'class' => ProductBillingEnum::class,
                'expanded' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please select the radio button.']),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductOffer::class,
        ]);
    }
}
