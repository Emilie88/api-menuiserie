<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContactRepository;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */


class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("contact:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups("contact:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=150)
     *  @Groups("contact:read")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=150)
     *  @Groups("contact:read")
     */
    private $subject;

    /**
     * @ORM\Column(type="text" )
     *  @Groups("contact:read")
     */
    private $message;

     /**
     * @ORM\Column(type="datetime")
     *  @Groups("contact:read")
     
     */
    private $date;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
