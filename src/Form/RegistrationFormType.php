<?php

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
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'auth.register.full_name',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'signupFullnameInput',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'auth.register.error.fullname_required',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'auth.register.email',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'signupEmailInput',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'auth.register.error.email_required',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => 'auth.register.password',
                    'attr' => [
                        'class' => 'form-control fakePassword',
                        'id' => 'formSignUpPassword',
                    ],
                ],
                'second_options' => [
                    'label' => 'auth.register.confirm_password',
                    'attr' => [
                        'class' => 'form-control fakePassword',
                        'id' => 'formSignUpConfirmPassword',
                    ],
                ],
                'invalid_message' => 'auth.register.error.passwords_mismatch',
                'constraints' => [
                    new NotBlank([
                        'message' => 'auth.register.error.password_required',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'auth.register.error.password_min_length',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'auth.register.error.agree_terms',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'auth',
        ]);
    }
}
