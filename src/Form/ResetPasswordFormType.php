<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'auth.reset_password.password',
                    'attr' => [
                        'class' => 'form-control fakePassword',
                        'id' => 'formResetPassword',
                    ],
                ],
                'second_options' => [
                    'label' => 'auth.reset_password.confirm_password',
                    'attr' => [
                        'class' => 'form-control fakePassword',
                        'id' => 'formResetConfirmPassword',
                    ],
                ],
                'invalid_message' => 'auth.reset_password.error.passwords_mismatch',
                'constraints' => [
                    new NotBlank([
                        'message' => 'auth.reset_password.error.password_required',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'auth.reset_password.error.password_min_length',
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'auth',
        ]);
    }
}
