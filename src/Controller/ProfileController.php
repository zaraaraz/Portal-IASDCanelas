<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileFormType;
use App\Form\ChangePasswordFormType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile_index')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        RoleRepository $roleRepository,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        // Profile info form
        $profileForm = $this->createForm(ProfileFormType::class, $user);
        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'profile.success.updated');

            return $this->redirectToRoute('profile_index');
        }

        // Change password form
        $passwordForm = $this->createForm(ChangePasswordFormType::class);
        $passwordForm->handleRequest($request);

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $currentPassword = $passwordForm->get('currentPassword')->getData();

            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('danger', 'profile.error.current_password_invalid');

                return $this->redirectToRoute('profile_index');
            }

            $newPassword = $passwordForm->get('newPassword')->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
            $entityManager->flush();

            $this->addFlash('success', 'profile.success.password_changed');

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('portal/profile.html.twig', [
            'profileForm' => $profileForm,
            'passwordForm' => $passwordForm,
            'roleMap' => $roleRepository->findAllIndexedByCode(),
        ]);
    }

    #[Route('/profile/avatar', name: 'profile_avatar', methods: ['POST'])]
    public function updateAvatar(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        $avatarFile = $request->files->get('avatar');
        if (!$avatarFile) {
            $this->addFlash('danger', 'profile.error.avatar_required');

            return $this->redirectToRoute('profile_index');
        }

        // Validate file type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($avatarFile->getMimeType(), $allowedMimes)) {
            $this->addFlash('danger', 'profile.error.avatar_invalid_type');

            return $this->redirectToRoute('profile_index');
        }

        // Validate file size (max 2MB)
        if ($avatarFile->getSize() > 2 * 1024 * 1024) {
            $this->addFlash('danger', 'profile.error.avatar_too_large');

            return $this->redirectToRoute('profile_index');
        }

        // Delete old avatar if exists
        $oldAvatar = $user->getAvatar();
        if ($oldAvatar) {
            $oldPath = $this->getParameter('kernel.project_dir') . '/public/uploads/avatars/' . $oldAvatar;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Generate unique filename
        $extension = $avatarFile->guessExtension() ?? 'jpg';
        $filename = $slugger->slug($user->getFullName()) . '-' . uniqid() . '.' . $extension;

        // Move file
        $avatarFile->move(
            $this->getParameter('kernel.project_dir') . '/public/uploads/avatars',
            $filename
        );

        $user->setAvatar($filename);
        $entityManager->flush();

        $this->addFlash('success', 'profile.success.avatar_updated');

        return $this->redirectToRoute('profile_index');
    }
}
