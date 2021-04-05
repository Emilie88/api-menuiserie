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
     * @ORM\Column(type="string")
     * @Groups("scheduler:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @Groups("scheduler:read")
     */
    private $start;

    /**
     * @ORM\Column(type="string")
     * @Groups("scheduler:read")
     */
    private $end;


    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups("scheduler:read")
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="schedulers", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
    
     */
    private $idUs;

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

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function setStart(?string $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?string
    {
        return $this->end;
    }

    public function setEnd(?string $end): self
    {
        $this->end = $end;

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

    public function getIdUs(): ?User
    {
        return $this->idUs;
    }

    public function setIdUs(?User $idUs): self
    {
        $this->idUs = $idUs;

        return $this;
    }
}
