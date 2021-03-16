<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups("comment:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups("comment:read","comment:write")
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups("comment:read","comment:write")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups("comment:read","comment:write")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     *  @Groups("comment:read","comment:write")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     *  @Groups("comment:read")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     *  @Groups("comment:read")
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(?string $rating): self
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

    public function getComment(): ?User
    {
        return $this->comment;
    }

    public function setComment(?User $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
