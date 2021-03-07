<?php

namespace App\Entity;


use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("rdv:read")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups("rdv:read")
     */
    private $motif;

    

    /**
     * @ORM\Column(type="datetime")
     * @Groups("rdv:read")
     */
    private $dateRdv;

   

    /**
     * @ORM\Column(type="time")
     */
    private $heure_rdv;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateRdv(): ?string
    {
        return $this->dateRdv;
    }

    public function setDateRdv(string $dateRdv): self
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getHeureRdv(): ?\DateTimeInterface
    {
        return $this->heure_rdv;
    }

    public function setHeureRdv(\DateTimeInterface $heure_rdv): self
    {
        $this->heure_rdv = $heure_rdv;

        return $this;
    }
}
