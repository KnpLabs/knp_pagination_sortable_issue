<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity(MovieRepository::class)]
class Movie
{
    #[Id]
    #[Column(type: UuidType::NAME)]
    private readonly Uuid $id;

    public function __construct(
        #[Column(length: 255)]
        private string $title,

        #[Column]
        private int $price,
    )
    {
        $this->id = Uuid::v7();
    }

    public function __toString()
    {
        return Movie::class."#{$this->id->toRfc4122()}";
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
}
