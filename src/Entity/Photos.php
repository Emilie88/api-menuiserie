<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 */
class Photos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameImage;

    /**
     * @ORM\OneToOne(targetEntity=Realisation::class, mappedBy="image", cascade={"persist", "remove"})
     */
    private $realisation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameImage(): ?string
    {
        return $this->nameImage;
    }

    public function setNameImage(string $nameImage): self
    {
        $this->nameImage = $nameImage;

        return $this;
    }

    public function getRealisation(): ?Realisation
    {
        return $this->realisation;
    }

    public function setRealisation(Realisation $realisation): self
    {
        // set the owning side of the relation if necessary
        if ($realisation->getImage() !== $this) {
            $realisation->setImage($this);
        }

        $this->realisation = $realisation;

        return $this;
    }
}
