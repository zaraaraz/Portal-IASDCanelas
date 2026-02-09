<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator,
        private string $senderEmail = 'noreply@portal-iasdcanelas.pt',
        private string $senderName = 'Portal IASDCanelas',
    ) {
    }

    public function sendResetPasswordEmail(User $user): void
    {
        $resetUrl = $this->urlGenerator->generate('auth_reset_password', [
            'token' => $user->getResetToken(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new TemplatedEmail())
            ->from(new Address($this->senderEmail, $this->senderName))
            ->to(new Address($user->getEmail(), $user->getFullName()))
            ->subject('Recuperação de Palavra-passe - Portal IASDCanelas')
            ->htmlTemplate('emails/reset-password.html.twig')
            ->context([
                'user' => $user,
                'resetUrl' => $resetUrl,
            ]);

        $this->mailer->send($email);
    }
}
