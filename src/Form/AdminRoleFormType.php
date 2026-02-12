<?php

namespace App\Form;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AdminRoleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'admin.roles.form.code',
                'attr' => ['class' => 'form-control', 'placeholder' => 'ROLE_EXEMPLO'],
                'constraints' => [
                    new NotBlank(message: 'O código é obrigatório.'),
                    new Regex(
                        pattern: '/^ROLE_[A-Z_]+$/',
                        message: 'O código deve começar com ROLE_ e conter apenas letras maiúsculas e underscores.',
                    ),
                ],
            ])
            ->add('displayName', TextType::class, [
                'label' => 'admin.roles.form.display_name',
                'attr' => ['class' => 'form-control', 'placeholder' => 'admin.roles.form.display_name_placeholder'],
                'constraints' => [
                    new NotBlank(message: 'O nome de exibição é obrigatório.'),
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'admin.roles.form.description',
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'admin.roles.form.description_placeholder'],
            ])
            ->add('badgeColor', ChoiceType::class, [
                'label' => 'admin.roles.form.badge_color',
                'choices' => [
                    'admin.roles.color.danger' => 'danger',
                    'admin.roles.color.primary' => 'primary',
                    'admin.roles.color.info' => 'info',
                    'admin.roles.color.warning' => 'warning',
                    'admin.roles.color.success' => 'success',
                    'admin.roles.color.secondary' => 'secondary',
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'admin.roles.form.sort_order',
                'attr' => ['class' => 'form-control', 'min' => 0],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
            'translation_domain' => 'dashboard',
        ]);
    }
}
