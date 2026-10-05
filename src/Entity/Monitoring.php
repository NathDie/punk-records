<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\MonitoringRepository;
use App\State\Provider\Monitoring\MonitoringCollectionProvider;
use App\Trait\ActivableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/monitorings',
            normalizationContext: [
                'groups' => ['monitoring:detail'],
            ],
            provider: MonitoringCollectionProvider::class,
        ),
        new Post(),
        new Get(),
        new Patch(),
        new Delete(),
    ]
)]
#[ORM\Entity(repositoryClass: MonitoringRepository::class)]
class Monitoring
{
    use ActivableTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['monitoring:detail'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['monitoring:detail'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['monitoring:detail'])]
    private ?string $link = null;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }
}
