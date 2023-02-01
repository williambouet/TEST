<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about_me = null;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: Artwork::class)]
    private Collection $artworks;

    #[ORM\OneToOne(inversedBy: 'artist', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Artwork::class, inversedBy: 'artists')]
    private Collection $favory;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'follower')]
    private Collection $follow;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'follow')]
    private Collection $follower;

    public function __construct()
    {
        $this->artworks = new ArrayCollection();
        $this->favory = new ArrayCollection();
        $this->follow = new ArrayCollection();
        $this->follower = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAboutMe(): ?string
    {
        return $this->about_me;
    }

    public function setAboutMe(?string $about_me): self
    {
        $this->about_me = $about_me;

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
            $artwork->setArtist($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getArtist() === $this) {
                $artwork->setArtist(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getFavory(): Collection
    {
        return $this->favory;
    }

    public function addFavory(Artwork $artwork): self
    {
        if (!$this->favory->contains($artwork)) {
            $this->favory->add($artwork);
        }

        return $this;
    }

    public function removeFavory(Artwork $artwork): self
    {
        $this->favory->removeElement($artwork);

        return $this;
    }

    public function isInFavorite(Artwork $artwork): bool
    {
        return $this->favory->contains($artwork);
    }

    /**
     * @return Collection<int, self>
     */
    public function getFollow(): Collection
    {
        return $this->follow;
    }

    public function addFollow(self $follow): self
    {
        if (!$this->follow->contains($follow)) {
            $this->follow->add($follow);
        }

        return $this;
    }

    public function removeFollow(self $follow): self
    {
        $this->follow->removeElement($follow);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFollower(): Collection
    {
        return $this->follower;
    }

    public function addFollower(self $follower): self
    {
        if (!$this->follower->contains($follower)) {
            $this->follower->add($follower);
            $follower->addFollow($this);
        }

        return $this;
    }

    public function removeFollower(self $follower): self
    {
        if ($this->follower->removeElement($follower)) {
            $follower->removeFollow($this);
        }

        return $this;
    }

    public function isFollow(Artist $artist): bool
    {
        return $this->follow->contains($artist);
    }

    public function isFollower(Artist $artist): bool
    {
        return $this->follower->contains($artist);
    }


}
