<?php

namespace App\Entity;

use App\Repository\QuackRepository;
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

    public function __construct() {
        $this->created_at = new \DateTimeImmutable();
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
}
