<?php

namespace App\Controller;


use App\Entity\Category;
use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/inspirations', name: 'app_inspiration_')]
class InspirationController extends AbstractController
{
    #[Route('/categorie/{id}', name: 'category', methods:['GET'])]
    public function index(Category $category, ArtworkRepository $artworkRepository): Response
    {

        return $this->render('category/inspiration.html.twig', [
            'artworks' => $artworkRepository->findBy(['category'=> $category->getId()]),
            'category' => $category,
        ]);
    }
}