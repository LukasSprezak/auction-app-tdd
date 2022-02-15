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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CustomerInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class, [
                'label' => 'Firstname',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your firstname.']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Please enter at least two characters.',
                        'max' => 50,
                        'maxMessage' => 'Please enter up to 50 characters.'
                    ])
                ],
            ])
            ->add('lastName',TextType::class, [
                'label' => 'Lastname',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your lastname.']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Please enter at least two characters.',
                        'max' => 50,
                        'maxMessage' => 'Please enter up to 50 characters.'
                    ])
                ],
            ])
            ->add('birthday', BirthdayType::class, [
                'widget' => 'single_text',
                'empty_data' => null,
                'required' => false,
            ])
            ->add('city',TextType::class, [
                'label' => 'City',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your city.']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Please enter at least two characters.',
                        'max' => 50,
                        'maxMessage' => 'Please enter up to 50 characters.'
                    ])
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your address.']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Please enter at least two characters.',
                        'max' => 120,
                        'maxMessage' => 'Please enter up to 120 characters.'
                    ])
                ],
            ])
            ->add('phoneNumber',TelType::class)
            ->add('zipCode',TextType::class)
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
