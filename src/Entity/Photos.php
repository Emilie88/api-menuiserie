<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhotosRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 */
class Photos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups("photos:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("photos:read")
     */
    private $nameImage;

    /**
     * @ORM\ManyToOne(targetEntity=Realisations::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     *  @Groups("photos:read","photos:write","realisations:read","realisations:write")
     */
    private $realisations;



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

    public function getRealisations(): ?Realisations
    {
        return $this->realisations;
    }

    public function setRealisations(?Realisations $realisations): self
    {
        $this->realisations = $realisations;

        return $this;
    }
}
