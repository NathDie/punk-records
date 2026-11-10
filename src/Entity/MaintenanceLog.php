<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\MaintenanceLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/maintenance-logs'
        ),
        new Patch(
            uriTemplate: '/maintenance-logs/{id}'
        ),
        new Delete(
            uriTemplate: '/maintenance-logs/{id}'
        ),
    ]
)]
#[ORM\Entity(repositoryClass: MaintenanceLogRepository::class)]
class MaintenanceLog
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['maintenance_log:detail'])]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['maintenance_log:detail'])]
    #[SerializedName('done_at')]
    private ?\DateTimeImmutable $doneAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['maintenance_log:detail'])]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'logs')]
    private ?Maintenance $maintenance = null;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDoneAt(): ?\DateTimeImmutable
    {
        return $this->doneAt;
    }

    public function setDoneAt(\DateTimeImmutable $doneAt): static
    {
        $this->doneAt = $doneAt;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getMaintenance(): ?Maintenance
    {
        return $this->maintenance;
    }

    public function setMaintenance(?Maintenance $maintenance): static
    {
        $this->maintenance = $maintenance;

        return $this;
    }
}
