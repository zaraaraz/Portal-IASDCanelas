<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pages', name: 'pages_')]
final class PagesController extends AbstractController
{
    #[Route('/blank', name: 'blank')]
    public function blank(): Response
    {
        return $this->render('pages/blank.html.twig');
    }

    // Error pages
    #[Route('/error/maintenance', name: 'error_maintenance')]
    public function maintenance(): Response
    {
        return $this->render('pages/error/maintenance.html.twig');
    }

    #[Route('/error/404', name: 'error_404')]
    public function error404(): Response
    {
        return $this->render('pages/error/404-error.html.twig');
    }

    // Authentication pages - redirect to real auth routes
    #[Route('/auth/sign-in', name: 'auth_sign_in')]
    public function signIn(): Response
    {
        return $this->redirectToRoute('auth_login');
    }

    #[Route('/auth/sign-up', name: 'auth_sign_up')]
    public function signUp(): Response
    {
        return $this->redirectToRoute('auth_register');
    }

    #[Route('/auth/forget-password', name: 'auth_forget_password')]
    public function forgetPassword(): Response
    {
        return $this->redirectToRoute('auth_forgot_password');
    }

    #[Route('/auth/reset-password', name: 'auth_reset_password')]
    public function resetPassword(): Response
    {
        return $this->redirectToRoute('auth_forgot_password');
    }

    #[Route('/auth/otp-verification', name: 'auth_otp_verification')]
    public function otpVerification(): Response
    {
        return $this->render('pages/authentication/otp-varification.html.twig');
    }
}
