<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\ProductOffer;
use App\Enum\CompanyOrIndividualEnum;
use App\Enum\StateProductEnum;
use App\Enum\StatusProductOfferEnum;
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
                'label' => 'title',
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
                    new NotBlank(['message' => 'Please enter a title.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'The title can be up to 120 characters long.'
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
            ->add('companyOrIndividual', EnumType::class, [
                'required' => true,
                'class' => CompanyOrIndividualEnum::class,
                'expanded' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please select the radio button.']),
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
            ->add('giveForFree', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom'
                ]
            ])
            ->add('enabled', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom'
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
