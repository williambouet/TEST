<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/oeuvres', name: 'app_artwork_')]
class ArtworkController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('artwork/index.html.twig', []);
    }

    #[Route('/ajouter', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArtworkRepository $artworkRepository): Response
    {
        /** @var User */
        $user = $this->getUser();

        $artwork = new Artwork();
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artwork->setArtist($user->getArtist());
            $artworkRepository->save($artwork, true);

            $this->addFlash('success', 'L\'œuvre a bien été ajoutée.');

            return $this->redirectToRoute('app_artwork_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artwork/new.html.twig', [
            'artwork' => $artwork,
            'form' => $form,
        ]);
    }



    #[Route('/{id}/modifier', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artwork $artwork, ArtworkRepository $artworkRepository): Response
    {
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artworkRepository->save($artwork, true);

            $this->addFlash('success', 'L\'œuvre a bien été modifiée.');

            return $this->redirectToRoute('app_artwork_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artwork/edit.html.twig', [
            'artwork' => $artwork,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Artwork $artwork, ArtworkRepository $artworkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $request->request->get('_token'))) {
            $artworkRepository->remove($artwork, true);
            $this->addFlash('success', 'L\'œuvre a bien été supprimée.');
        }

        return $this->redirectToRoute('app_artwork_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ajouter-aux-favories/{id}', methods: ['GET', 'POST'], name: 'add_favory')]
public function addToFavories(Artwork $artwork, ArtistRepository $artistRepository): Response
{
    if (!$artwork) {
            $this->addFlash("danger", "Aucune œuvre correspondante trouvée.");
    }      

    /** @var \App\Entity\User */
    $user = $this->getUser();
    $artist = $user->getArtist();

    if ($artist->isInFavorite($artwork)) {
        $artist->removeFavory($artwork);
    } else {
        $artist->addFavory($artwork);
    }        

    $artistRepository->save($artist, true);        

    return $this->json(['isInFavorite' => $artist->getFavory()->contains($artwork)]);
}
}
