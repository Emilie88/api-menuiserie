<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RealisationsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RealisationsRepository::class)
 */
class Realisations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("realisations:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("realisations:read")
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("realisations:read")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     *  @Groups("realisations:read")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Photos::class, mappedBy="realisations",orphanRemoval=true, cascade={"persist"})
     * @Groups("realisations:read")
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Photos[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Photos $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setRealisations($this);
        }

        return $this;
    }

    public function removeImage(Photos $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getRealisations() === $this) {
                $image->setRealisations(null);
            }
        }

        return $this;
    }
}
