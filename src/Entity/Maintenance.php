<?php

namespace App\Entity;

use App\Enum\RecurrenceRule;
use App\Enum\Status;
use App\Repository\MaintenanceRepository;
use App\Trait\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Maintenance
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(enumType: RecurrenceRule::class)]
    private ?RecurrenceRule $frequency = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $lastDoneAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $nextDueAt = null;

    #[ORM\Column(enumType: Status::class)]
    private ?Status $status = null;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getFrequency(): ?RecurrenceRule
    {
        return $this->frequency;
    }

    public function setFrequency(RecurrenceRule $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getLastDoneAt(): ?\DateTimeImmutable
    {
        return $this->lastDoneAt;
    }

    public function setLastDoneAt(?\DateTimeImmutable $lastDoneAt): static
    {
        $this->lastDoneAt = $lastDoneAt;

        return $this;
    }

    public function getNextDueAt(): ?\DateTimeImmutable
    {
        return $this->nextDueAt;
    }

    public function setNextDueAt(?\DateTimeImmutable $nextDueAt): static
    {
        $this->nextDueAt = $nextDueAt;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }
}
