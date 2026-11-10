<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\MaintenanceStatus;
use App\Enum\RecurrenceRule;
use App\Repository\MaintenanceRepository;
use App\State\Provider\Monitoring\MonitoringCollectionProvider;
use App\Trait\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/maintenances',
            normalizationContext: [
                'groups' => ['maintenance:detail', 'maintenance_log:detail'],
            ],
        ),
        new Post(),
        new Get(),
        new Patch(),
        new Delete(),
    ]
)]
#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Maintenance
{
    use TimestampTrait;

    public const TODO_WINDOW_DAYS = 7;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['maintenance:detail'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['maintenance:detail'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['maintenance:detail'])]
    private ?string $description = null;

    #[ORM\Column(enumType: RecurrenceRule::class)]
    #[Groups(['maintenance:detail'])]
    private ?RecurrenceRule $frequency = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[Groups(['maintenance:detail'])]
    #[SerializedName('last_done_at')]
    private ?\DateTimeImmutable $lastDoneAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[Groups(['maintenance:detail'])]
    #[SerializedName('next_due_at')]
    private ?\DateTimeImmutable $nextDueAt = null;

    /**
     * @var Collection<int, MaintenanceLog>
     */
    #[ORM\OneToMany(targetEntity: MaintenanceLog::class, mappedBy: 'maintenance', cascade: ['persist', 'remove'])]
    #[Groups(['maintenance:detail'])]
    private Collection $logs;

    private MaintenanceStatus $status;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->logs = new ArrayCollection();
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

    /**
     * @return Collection<int, MaintenanceLog>
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(MaintenanceLog $log): static
    {
        if (!$this->logs->contains($log)) {
            $this->logs->add($log);
            $log->setMaintenance($this);
        }

        return $this;
    }

    public function removeLog(MaintenanceLog $log): static
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getMaintenance() === $this) {
                $log->setMaintenance(null);
            }
        }

        return $this;
    }

    #[Groups(['maintenance:detail'])]
    #[SerializedName('status')]
    public function getStatus(): MaintenanceStatus
    {
        if ($this->nextDueAt === null) {
            return MaintenanceStatus::UP_TO_DATE;
        }

        $today = new \DateTimeImmutable('today');

        if ($this->nextDueAt < $today) {
            return MaintenanceStatus::OVERDUE;
        }

        if ($this->nextDueAt <= $today->modify('+' . self::TODO_WINDOW_DAYS . ' days')) {
            return MaintenanceStatus::TODO;
        }

        return MaintenanceStatus::UP_TO_DATE;
    }

    #[Ignore]
    public function getDueStateLabel(): string
    {
        return $this->getStatus()->label();
    }
}
