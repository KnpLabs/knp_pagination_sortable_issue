<?php

declare(strict_types=1);

namespace App\Controller;

use App\Collection\Movies;
use App\Entity\Movie;
use App\Form\Movie\AddMovieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/movie', 'movie_')]
class MovieController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Movies $movies,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {}

    #[Route('/add', 'add', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function add(Request $request): Response
    {
        $form = $this->createForm(AddMovieType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $movie = new Movie($data['title'], $data['price']);
            $this->movies->add($movie);
            $this->entityManager->flush();

            return $this->redirect($this->urlGenerator->generate('movie_list'));
        }

        return $this->render('movie/add.html.twig', [ 'form' => $form ]);
    }

    #[Route('/', 'list', methods: Request::METHOD_GET)]
    public function list(Request $request): Response
    {
        $pagination = $this->movies->all((int) $request->query->get('page', 1));

        return $this->render('movie/list.html.twig', [ 'pagination' => $pagination ]);
    }
}
