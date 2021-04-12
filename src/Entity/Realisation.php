<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RealisationRepository;
use Symfony\Component\Serializer\Annotation\Groups;





class Realisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("realisation:read")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("realisation:read")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("realisation:read")
     */
    private $description;




    /**
     * @ORM\Column(type="datetime")
    
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=Photos::class, inversedBy="realisation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;













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

    public function getImage(): ?Photos
    {
        return $this->image;
    }

    public function setImage(Photos $image): self
    {
        $this->image = $image;

        return $this;
    }
}
