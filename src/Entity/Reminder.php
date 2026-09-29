<?php

namespace App\Entity;

use App\Enum\RecurrenceRule;
use App\Enum\Status;
use App\Repository\ReminderRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ReminderRepository::class)]
class Reminder
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?DateTimeImmutable $remindAt = null;

    #[ORM\Column(enumType: RecurrenceRule::class)]
    private ?RecurrenceRule $recurring = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $snoozedUntil = null;

    #[ORM\Column(enumType: Status::class)]
    private ?Status $status = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
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

    public function getRemindAt(): ?DateTimeImmutable
    {
        return $this->remindAt;
    }

    public function setRemindAt(DateTimeImmutable $remindAt): static
    {
        $this->remindAt = $remindAt;

        return $this;
    }

    public function getRecurring(): ?RecurrenceRule
    {
        return $this->recurring;
    }

    public function setRecurring(RecurrenceRule $recurring): static
    {
        $this->recurring = $recurring;

        return $this;
    }

    public function getSnoozedUntil(): ?DateTimeImmutable
    {
        return $this->snoozedUntil;
    }

    public function setSnoozedUntil(?DateTimeImmutable $snoozedUntil): static
    {
        $this->snoozedUntil = $snoozedUntil;

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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
