<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\InventoryCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/inventory-categories',
            normalizationContext: [
                'groups' => ['inventory_category:detail'],
            ],
        ),
        new Get(
            uriTemplate: '/inventory-categories/{id}',
            normalizationContext: [
                'groups' => ['inventory_category:detail'],
            ],
        ),
        new Post(
            uriTemplate: '/inventory-categories',
        ),
        new Delete(
            uriTemplate: '/inventory-categories/{id}'
        ),
    ]
)]
#[ORM\Entity(repositoryClass: InventoryCategoryRepository::class)]
class InventoryCategory
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['inventory_category:detail'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['inventory_category:detail'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Inventory>
     */
    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'category')]
    private Collection $inventories;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->inventories = new ArrayCollection();
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

    /**
     * @return Collection<int, Inventory>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): static
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories->add($inventory);
            $inventory->setCategory($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): static
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getCategory() === $this) {
                $inventory->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
