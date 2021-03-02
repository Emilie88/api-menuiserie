<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
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
     * @Groups("comment:read")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups("comment:read")
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("comment:read")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("comment:read")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("comment:read")
     */
    private $content;

    

    /**
     * @ORM\Column(type="datetime")
     * @Groups("comment:read")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentsList")
     * @Groups("comment:read","user:write","user:read")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

   

    

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    // public function getIdComment(): ?User
    // {
    //     return $this->idComment;
    // }

    // public function setIdComment(?User $idComment): self
    // {
    //     $this->idComment = $idComment;

    //     return $this;
    // }
}
