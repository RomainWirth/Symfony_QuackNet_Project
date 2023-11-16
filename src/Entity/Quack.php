<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min: 0,
        max: 280,
        maxMessage: 'There is a quack too long. Way too many things to say!'
    )]
    #[Assert\NotBlank(message: 'Title can\'t be empty! Dude, write something here')]
    private ?string $content = null;

    #[ORM\Column(type:Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tags = null;

    #[ORM\ManyToOne(inversedBy: 'quacks')]
    #[ORM\JoinColumn(nullable: false)]
    public ?User $user_id = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'comment')]
    public ?self $motherquack_id = null;

    #[ORM\OneToMany(mappedBy: 'motherquack_id', targetEntity: self::class)]
    private Collection $comment;


    public function __construct() {
        $this->created_at = new \DateTimeImmutable();
        $this->comment = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function setContent(string $content): static {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getMotherquackId(): ?self
    {
        return $this->motherquack_id;
    }

    public function setMotherquackId(?self $motherquack_id): static
    {
        $this->motherquack_id = $motherquack_id;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(self $comment): static
    {
        if (!$this->comment->contains($comment)) {
            $this->comment->add($comment);
            $comment->setMotherquackId($this);
        }

        return $this;
    }

    public function removeComment(self $comment): static
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMotherquackId() === $this) {
                $comment->setMotherquackId(null);
            }
        }

        return $this;
    }

}
