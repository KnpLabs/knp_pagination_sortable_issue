<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 */
final class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Movie::class);
    }

    public function add(Movie $movie): void
    {
        $this->entityManager->persist($movie);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
