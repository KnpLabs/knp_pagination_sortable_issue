<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Form\Movie\AddMovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/movie', 'movie_')]
class MovieController extends AbstractController
{
    public function __construct(
        private readonly MovieRepository $movieRepository,
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
            $this->movieRepository->add($movie);
            $this->movieRepository->flush();

            return $this->redirect($this->urlGenerator->generate('movie_list'));
        }

        return $this->render('movie/add.html.twig', [ 'form' => $form ]);
    }

    #[Route('/', 'list', methods: Request::METHOD_GET)]
    public function list(): Response
    {
        $movies = $this->movieRepository->findAll();

        return $this->render('movie/list.html.twig', [ 'movies' => $movies ]);
    }
}
