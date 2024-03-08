<?php

declare(strict_types=1);

namespace App\Collection;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Movies
{
    public function __construct(
        private MovieRepository $movieRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function add(Movie $movie): void
    {
        $this->entityManager->persist($movie);
    }

    public function all(): iterable
    {
        return $this->movieRepository->getQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }
}
