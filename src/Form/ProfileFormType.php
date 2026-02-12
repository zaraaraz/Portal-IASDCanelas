<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'profile.form.full_name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'profile.form.full_name_placeholder',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'profile.error.fullname_required',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'profile.form.email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'profile.form.email_placeholder',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'profile.error.email_required',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'dashboard',
        ]);
    }
}
