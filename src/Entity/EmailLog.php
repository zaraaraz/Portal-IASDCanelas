<?php

namespace App\Entity;

use App\Repository\EmailLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmailLogRepository::class)]
#[ORM\Table(name: 'email_log')]
#[ORM\Index(columns: ['recipient_email'], name: 'idx_email_log_recipient')]
#[ORM\Index(columns: ['status'], name: 'idx_email_log_status')]
#[ORM\Index(columns: ['type'], name: 'idx_email_log_type')]
class EmailLog
{
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    public const TYPE_RESET_PASSWORD = 'reset_password';
    public const TYPE_WELCOME = 'welcome';
    public const TYPE_NOTIFICATION = 'notification';
    public const TYPE_OTHER = 'other';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $recipientEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recipientName = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $errorMessage = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $sentAt = null;

    public function __construct()
    {
        $this->sentAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipientEmail(): ?string
    {
        return $this->recipientEmail;
    }

    public function setRecipientEmail(string $recipientEmail): static
    {
        $this->recipientEmail = $recipientEmail;

        return $this;
    }

    public function getRecipientName(): ?string
    {
        return $this->recipientName;
    }

    public function setRecipientName(?string $recipientName): static
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): static
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSentAt(): ?\DateTimeImmutable
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeImmutable $sentAt): static
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_SENT => 'bg-success',
            self::STATUS_FAILED => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    public function getTypeLabel(): string
    {
        return match ($this->type) {
            self::TYPE_RESET_PASSWORD => 'Reset Password',
            self::TYPE_WELCOME => 'Boas-vindas',
            self::TYPE_NOTIFICATION => 'Notificação',
            self::TYPE_OTHER => 'Outro',
            default => $this->type,
        };
    }
}
