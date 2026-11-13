<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/books',
            normalizationContext: [
                'groups' => ['book:detail', 'book_category:detail', 'book_author:detail'],
            ],
        ),
        new Get(
            uriTemplate: '/books/{id}',
            normalizationContext: [
                'groups' => ['book:detail', 'book_category:detail', 'book_author:detail'],
            ],
        ),
        new Post(
            uriTemplate: '/books',
        ),
        new Patch(
            uriTemplate: '/books/{id}'
        ),
        new Delete(
            uriTemplate: '/books/{id}'
        ),
    ]
)]
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['book:detail'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:detail'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['book:detail'])]
    private ?string $synopsis = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['book:detail'])]
    #[SerializedName('published_at')]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column]
    #[Groups(['book:detail'])]
    private ?bool $reading = false;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'books')]
    private ?Author $author = null;

    /**
     * @var Collection<int, BookCategory>
     */
    #[ORM\ManyToMany(targetEntity: BookCategory::class, inversedBy: 'books', cascade: ['persist', 'remove'])]
    private Collection $categories;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->categories = new ArrayCollection();
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

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function isReading(): ?bool
    {
        return $this->reading;
    }

    public function setReading(bool $reading): static
    {
        $this->reading = $reading;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, BookCategory>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(BookCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(BookCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
