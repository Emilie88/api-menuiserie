<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SchedulerRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SchedulerRepository::class)
 */
class Scheduler
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("scheduler:read")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups("scheduler:read")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("scheduler:read")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("scheduler:read")
     */
    private $end;


    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("scheduler:read")
     */
    private $color;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }





    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
