<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\RoleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminUserFormType extends AbstractType
{
    public function __construct(
        private RoleRepository $roleRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'];

        $builder
            ->add('fullName', TextType::class, [
                'label' => 'admin.users.form.full_name',
                'attr' => ['class' => 'form-control', 'placeholder' => 'admin.users.form.full_name_placeholder'],
                'constraints' => [
                    new NotBlank(message: 'O nome é obrigatório.'),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'admin.users.form.email',
                'attr' => ['class' => 'form-control', 'placeholder' => 'admin.users.form.email_placeholder'],
                'constraints' => [
                    new NotBlank(message: 'O email é obrigatório.'),
                    new Email(message: 'O email não é válido.'),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'admin.users.form.roles',
                'choices' => $this->getRoleChoices(),
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'form-check-group'],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'admin.users.form.is_active',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ])
        ;

        // Password is required only when creating, optional when editing
        $passwordConstraints = [];
        if (!$isEdit) {
            $passwordConstraints[] = new NotBlank(message: 'A palavra-passe é obrigatória.');
        }
        $passwordConstraints[] = new Length(
            min: 8,
            minMessage: 'A palavra-passe deve ter pelo menos 8 caracteres.',
        );

        $builder->add('plainPassword', PasswordType::class, [
            'label' => $isEdit ? 'admin.users.form.new_password' : 'admin.users.form.password',
            'mapped' => false,
            'required' => !$isEdit,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $isEdit ? 'admin.users.form.new_password_placeholder' : 'admin.users.form.password_placeholder',
            ],
            'constraints' => $passwordConstraints,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'dashboard',
            'is_edit' => false,
        ]);

        $resolver->setAllowedTypes('is_edit', 'bool');
    }

    private function getRoleChoices(): array
    {
        $roles = $this->roleRepository->findAllIndexedByCode();
        $choices = [];

        foreach ($roles as $code => $role) {
            if ($code === 'ROLE_USER') {
                continue; // ROLE_USER is always added automatically
            }
            $choices[$role->getDisplayName()] = $code;
        }

        return $choices;
    }
}
