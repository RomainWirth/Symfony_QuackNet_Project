<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $quack = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuack(): ?string
    {
        return $this->quack;
    }

    public function setQuack(string $quack): static
    {
        $this->quack = $quack;

        return $this;
    }
}
