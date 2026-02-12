<?php

namespace App\Service;

use App\Entity\EmailLog;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator,
        private EntityManagerInterface $entityManager,
        private string $senderEmail = 'noreply@portal-iasdcanelas.pt',
        private string $senderName = 'Portal IASDCanelas',
    ) {
    }

    public function sendResetPasswordEmail(User $user): void
    {
        $resetUrl = $this->urlGenerator->generate('auth_reset_password', [
            'token' => $user->getResetToken(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $subject = 'Recuperação de Palavra-passe - Portal IASDCanelas';

        $email = (new TemplatedEmail())
            ->from(new Address($this->senderEmail, $this->senderName))
            ->to(new Address($user->getEmail(), $user->getFullName()))
            ->subject($subject)
            ->htmlTemplate('emails/reset-password.html.twig')
            ->context([
                'user' => $user,
                'resetUrl' => $resetUrl,
            ]);

        $this->sendAndLog(
            email: $email,
            recipientEmail: $user->getEmail(),
            recipientName: $user->getFullName(),
            subject: $subject,
            type: EmailLog::TYPE_RESET_PASSWORD,
            user: $user,
        );
    }

    private function sendAndLog(
        TemplatedEmail $email,
        string $recipientEmail,
        ?string $recipientName,
        string $subject,
        string $type,
        ?User $user = null,
    ): void {
        $log = new EmailLog();
        $log->setRecipientEmail($recipientEmail);
        $log->setRecipientName($recipientName);
        $log->setSubject($subject);
        $log->setType($type);
        $log->setUser($user);
        $log->setStatus(EmailLog::STATUS_FAILED);

        try {
            $this->mailer->send($email);
            $log->setStatus(EmailLog::STATUS_SENT);
        } catch (\Throwable $e) {
            $log->setErrorMessage($e->getMessage());

            throw $e;
        } finally {
            $this->entityManager->persist($log);
            $this->entityManager->flush();
        }
    }
}
