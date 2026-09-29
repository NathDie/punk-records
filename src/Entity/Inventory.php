<?php

namespace App\Entity;

use App\Enum\EquipmentStatus;
use App\Repository\InventoryRepository;
use App\Trait\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantity = 1;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $purchaseDate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0, nullable: true)]
    private ?string $purchasePrice = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $warrantyExpiresAt = null;

    #[ORM\Column(enumType: EquipmentStatus::class)]
    private ?EquipmentStatus $equipmentStatus = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'inventories')]
    private ?self $usedBy = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'usedBy')]
    private Collection $inventories;

    #[ORM\ManyToOne(inversedBy: 'inventories')]
    private ?InventoryCategory $category = null;

    #[ORM\ManyToOne(inversedBy: 'inventories')]
    private ?Location $location = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeImmutable
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(?\DateTimeImmutable $purchaseDate): static
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getPurchasePrice(): ?string
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?string $purchasePrice): static
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getWarrantyExpiresAt(): ?\DateTimeImmutable
    {
        return $this->warrantyExpiresAt;
    }

    public function setWarrantyExpiresAt(?\DateTimeImmutable $warrantyExpiresAt): static
    {
        $this->warrantyExpiresAt = $warrantyExpiresAt;

        return $this;
    }

    public function getEquipmentStatus(): ?EquipmentStatus
    {
        return $this->equipmentStatus;
    }

    public function setEquipmentStatus(EquipmentStatus $equipmentStatus): static
    {
        $this->equipmentStatus = $equipmentStatus;

        return $this;
    }

    public function getUsedBy(): ?self
    {
        return $this->usedBy;
    }

    public function setUsedBy(?self $usedBy): static
    {
        $this->usedBy = $usedBy;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(self $inventory): static
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories->add($inventory);
            $inventory->setUsedBy($this);
        }

        return $this;
    }

    public function removeInventory(self $inventory): static
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getUsedBy() === $this) {
                $inventory->setUsedBy(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?InventoryCategory
    {
        return $this->category;
    }

    public function setCategory(?InventoryCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
