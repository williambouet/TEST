<?php

namespace App\Controller;

use App\Entity\Artist;
use PhpParser\Builder\Method;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/artiste', name: 'app_artist_')]
class ArtistController extends AbstractController
{
    
    #[Route('/focus-sur-un-artiste/{id}', name: 'show_one_artist', methods: ['GET'])]
    public function showOneArtist(Artist $artist,): Response
    {
        
        return $this->render('artist/showOneArtist.html.twig', [
            'artist' => $artist,
        ]);
    }
    
    #[Route('/tous-les-artistes', name: 'all')]
    public function index(ArtistRepository $artistRepository): Response
    {
    
        return $this->render('artist/index.html.twig', [
            'artists' => $artistRepository->findBy([], ['id' => 'ASC'])
        ]);
    }
}
