<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public const NUMBER_OF_ARTISTS_IN_FOCUS = 4;

    #[Route('/', name: 'app_index')]
    public function index(CategoryRepository $categoryRepository, ArtistRepository $artistRepository): Response
    {

        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findBy([], ['id' => 'ASC']),
            'artists' => $artistRepository->findBy([], ['id' => 'ASC'], self::NUMBER_OF_ARTISTS_IN_FOCUS),
        ]);
    }
}
