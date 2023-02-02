<?php

namespace App\Entity;

use DateTimeImmutable;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\DBAL\Types\Types;
use App\Entity\Artwork;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Vich\Uploadable]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $placeholder = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Artwork::class)]
    private Collection $artworks;
    
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        )]
    #[Vich\UploadableField(mapping: 'category_file', fileNameProperty: 'placeholder')]
    private ?File $categoryFile = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;
    
    public function __construct()
    {
        $this->artworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getArtworks(): Collection
    {
        return $this->artworks;
    }

    public function addArtwork(Artwork $artwork): self
    {
        if (!$this->artworks->contains($artwork)) {
            $this->artworks->add($artwork);
            $artwork->setCategory($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getCategory() === $this) {
                $artwork->setCategory(null);
            }
        }

        return $this;
    }

     public function getCategoryFile(): ?File
    {
        return $this->categoryFile;
    }

    public function setCategoryFile(?File $image = null): self
    {
        $this->categoryFile = $image;

        if ($image) {
            $this->updatedAt = new DateTimeImmutable();
        }
        
        return $this;
    }

      public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
