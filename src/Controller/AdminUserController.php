<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserFormType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserController extends AbstractController
{
    #[Route('/users', name: 'admin_users_index')]
    public function index(UserRepository $userRepository, RoleRepository $roleRepository): Response
    {
        $users = $userRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('portal/admin/users/index.html.twig', [
            'users' => $users,
            'roleMap' => $roleRepository->findAllIndexedByCode(),
        ]);
    }

    #[Route('/users/new', name: 'admin_users_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        RoleRepository $roleRepository,
    ): Response {
        $user = new User();

        $form = $this->createForm(AdminUserFormType::class, $user, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'admin.users.success.created');

            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('portal/admin/users/form.html.twig', [
            'form' => $form,
            'user' => $user,
            'isEdit' => false,
            'roleMap' => $roleRepository->findAllIndexedByCode(),
        ]);
    }

    #[Route('/users/{id}/edit', name: 'admin_users_edit')]
    public function edit(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        RoleRepository $roleRepository,
    ): Response {
        $form = $this->createForm(AdminUserFormType::class, $user, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            }

            $entityManager->flush();

            $this->addFlash('success', 'admin.users.success.updated');

            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('portal/admin/users/form.html.twig', [
            'form' => $form,
            'user' => $user,
            'isEdit' => true,
            'roleMap' => $roleRepository->findAllIndexedByCode(),
        ]);
    }

    #[Route('/users/{id}/toggle-active', name: 'admin_users_toggle_active', methods: ['POST'])]
    public function toggleActive(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        if (!$this->isCsrfTokenValid('toggle-active-' . $user->getId(), $request->request->get('_token'))) {
            $this->addFlash('danger', 'admin.users.error.invalid_token');

            return $this->redirectToRoute('admin_users_index');
        }

        // Prevent self-deactivation
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($user->getId() === $currentUser->getId()) {
            $this->addFlash('danger', 'admin.users.error.cannot_deactivate_self');

            return $this->redirectToRoute('admin_users_index');
        }

        $user->setIsActive(!$user->isActive());
        $entityManager->flush();

        $this->addFlash('success', 'admin.users.success.active_toggled');

        return $this->redirectToRoute('admin_users_index');
    }
}
