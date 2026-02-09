<?php

namespace App\Entity;

use App\Repository\ChangelogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChangelogRepository::class)]
#[ORM\Table(name: 'changelog')]
#[ORM\HasLifecycleCallbacks]
class Changelog
{
    public const TYPE_FEATURE = 'feature';
    public const TYPE_BUGFIX = 'bugfix';
    public const TYPE_IMPROVEMENT = 'improvement';
    public const TYPE_SECURITY = 'security';
    public const TYPE_BREAKING = 'breaking';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $version = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 30)]
    private ?string $type = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->date = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTypeBadgeClass(): string
    {
        return match ($this->type) {
            self::TYPE_FEATURE => 'bg-success',
            self::TYPE_BUGFIX => 'bg-danger',
            self::TYPE_IMPROVEMENT => 'bg-info',
            self::TYPE_SECURITY => 'bg-warning',
            self::TYPE_BREAKING => 'bg-dark',
            default => 'bg-secondary',
        };
    }

    public function getTypeIcon(): string
    {
        return match ($this->type) {
            self::TYPE_FEATURE => 'ti ti-sparkles',
            self::TYPE_BUGFIX => 'ti ti-bug',
            self::TYPE_IMPROVEMENT => 'ti ti-arrow-up-circle',
            self::TYPE_SECURITY => 'ti ti-shield-lock',
            self::TYPE_BREAKING => 'ti ti-alert-triangle',
            default => 'ti ti-info-circle',
        };
    }
}
