<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\Priority;
use App\Enum\Status;
use App\Repository\TaskRepository;
use App\State\Provider\TaskTokayCollectionProvider;
use App\Trait\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/tasks/today',
            normalizationContext: [
                'groups' => ['task:detail'],
            ],
            provider: TaskTokayCollectionProvider::class,
        ),
        new Post(),
        new Get(),
        new Patch(),
        new Delete(),
    ]
)]
#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Task
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['task:detail'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['task:detail'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['task:detail'])]
    private ?string $description = null;

    #[ORM\Column(enumType: Status::class)]
    #[Groups(['task:detail'])]
    private ?Status $status = null;

    #[ORM\Column(enumType: Priority::class)]
    #[Groups(['task:detail'])]
    private ?Priority $priority = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[Groups(['task:detail'])]
    #[SerializedName('due_date')]
    private ?\DateTimeImmutable $dueDate = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['task:detail'])]
    #[SerializedName('complete_at')]
    private ?\DateTimeImmutable $completeAt = null;

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

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(Priority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeImmutable $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getCompleteAt(): ?\DateTimeImmutable
    {
        return $this->completeAt;
    }

    public function setCompleteAt(?\DateTimeImmutable $completeAt): static
    {
        $this->completeAt = $completeAt;

        return $this;
    }
}
