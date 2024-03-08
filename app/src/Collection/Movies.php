<?php

declare(strict_types=1);

namespace App\Collection;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final readonly class Movies
{
    public function __construct(
        private MovieRepository $movieRepository,
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
    ) {}

    public function add(Movie $movie): void
    {
        $this->entityManager->persist($movie);
    }

    /**
     * @return PaginationInterface<int,Movie>
     */
    public function all(int $page): PaginationInterface
    {
        $query = $this->movieRepository
            ->getQueryBuilder()
            ->getQuery()
        ;

        return $this->paginator->paginate($query, $page, 2);
    }
}
