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
     * @ORM\Column(type="text", nullable=true)
     * @Groups("scheduler:read")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("scheduler:read")
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("scheduler:read")
     */
    private $startDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("scheduler:read")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $idUser;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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
}
