<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new Email,
                    new NotBlank(['message' => 'Please enter your email address.']),
                    new Length([
                        'max' => 32,
                        'maxMessage' => 'Please enter up to 32 characters.'
                    ])
                ],
            ])
            ->add('username', TextType::class, [
                'label' => 'Username',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your username.']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Please enter at least two characters.',
                        'max' => 32,
                        'maxMessage' => 'Please enter up to 32 characters.'
                    ])
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label_attr' => [
                    'class' => 'switch-custom'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],

            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeated password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 32,
                    ]),
                ],
            ])
        ;
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
//            'cascade_validation' => true,
//            'validation_groups' => array('Default', 'Registration')
        ]);
    }
}
