<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\AdminRoleFormType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminRoleController extends AbstractController
{
    #[Route('/roles', name: 'admin_roles_index')]
    public function index(RoleRepository $roleRepository): Response
    {
        $roles = $roleRepository->findBy([], ['sortOrder' => 'ASC']);

        return $this->render('portal/admin/roles/index.html.twig', [
            'roles' => $roles,
        ]);
    }

    #[Route('/roles/new', name: 'admin_roles_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $role = new Role();

        $form = $this->createForm(AdminRoleFormType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($role);
            $entityManager->flush();

            $this->addFlash('success', 'admin.roles.success.created');

            return $this->redirectToRoute('admin_roles_index');
        }

        return $this->render('portal/admin/roles/form.html.twig', [
            'form' => $form,
            'role' => $role,
            'isEdit' => false,
        ]);
    }

    #[Route('/roles/{id}/edit', name: 'admin_roles_edit')]
    public function edit(
        Role $role,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(AdminRoleFormType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'admin.roles.success.updated');

            return $this->redirectToRoute('admin_roles_index');
        }

        return $this->render('portal/admin/roles/form.html.twig', [
            'form' => $form,
            'role' => $role,
            'isEdit' => true,
        ]);
    }

    #[Route('/roles/{id}/delete', name: 'admin_roles_delete', methods: ['POST'])]
    public function delete(
        Role $role,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        if (!$this->isCsrfTokenValid('delete-role-' . $role->getId(), $request->request->get('_token'))) {
            $this->addFlash('danger', 'admin.roles.error.invalid_token');

            return $this->redirectToRoute('admin_roles_index');
        }

        // Prevent deleting ROLE_USER and ROLE_ADMIN
        if (in_array($role->getCode(), ['ROLE_USER', 'ROLE_ADMIN'], true)) {
            $this->addFlash('danger', 'admin.roles.error.cannot_delete_system');

            return $this->redirectToRoute('admin_roles_index');
        }

        $entityManager->remove($role);
        $entityManager->flush();

        $this->addFlash('success', 'admin.roles.success.deleted');

        return $this->redirectToRoute('admin_roles_index');
    }
}
