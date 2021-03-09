<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OpinionsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OpinionsRepository::class)
 */
class Opinions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Groups("opinions:read")
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("opinions:read")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("opinions:read")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("opinions:read")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("opinions:read")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("opinions:read")
     */
    private $opinion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOpinion(): ?User
    {
        return $this->opinion;
    }

    public function setOpinion(?User $opinion): self
    {
        $this->opinion = $opinion;

        return $this;
    }
}
