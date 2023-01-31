<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Artist;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/artiste', name: 'app_artist_')]
class ArtistController extends AbstractController
{
    #[Route('/modifier', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        /** @var User */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $this->addFlash('success', 'Votre profil est bien modifié.');

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artist/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
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
