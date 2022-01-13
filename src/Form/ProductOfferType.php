<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\ProductOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description')
            ->add('images')
            ->add('price')
            ->add('stateOfProduct')
            ->add('giveForFree')
            ->add('enabled')
            ->add('productOwner')
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductOffer::class,
        ]);
//        $resolver->setDefaults([
//            'empty_data' => function (FormInterface $form) {
//                return new ProductOffer($form->get('title')->getData());
//            },
//        ]);
    }
}
