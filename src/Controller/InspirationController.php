<?php

namespace App\Controller;


use DateTime;
use App\Entity\User;
use App\Entity\Artwork;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\CommentType;
use App\Repository\ArtworkRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/inspirations', name: 'app_inspiration_')]
class InspirationController extends AbstractController
{
    #[Route('/categorie/{id}', name: 'category', methods: ['GET'])]
    public function index(Category $category, ArtworkRepository $artworkRepository): Response
    {

        return $this->render('category/inspiration.html.twig', [
            'artworks' => $artworkRepository->findBy(['category' => $category->getId()]),
            'category' => $category,
        ]);
    }

    #[Route('/categorie/oeuvre/{id}', name: 'artwork', methods: ['GET', 'POST'])]
    public function show(
        Artwork $artwork,
        Request $request,
        CommentRepository $commentRepository
    ): Response {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        /** @var User */
        $user = $this->getUser();
        $author = $user->getArtist();
        $date = new DateTimeImmutable();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreationDate($date);
            $comment->setAuthor($author);
            $comment->setArtwork($artwork);
            $commentRepository->save($comment, true);

            //TODO:redirection vers la page en cours, si possible en JSON ou essayer en pointant vers un embedding qui render de twig
            return $this->redirectToRoute('app_inspiration_artwork', ['id' => $artwork->getId(), '_fragment' => 'anchor'], Response::HTTP_SEE_OTHER);
        }

        $tchatters = [];
        $comments = $commentRepository->findBy(['artwork' => $artwork], ['creationDate' => 'DESC']);

        foreach ($comments as $comment) {
            
            if (!in_array($comment->getAuthor(), $tchatters)) {
                $tchatters[] = $comment->getAuthor();
                
            }
        }
        
        return $this->render('category/inspirationShow.html.twig', [
            'artwork' => $artwork,
            'comment' => $comment,
            'form' => $form,
            'comments' => $comments,
            'tchatters' => $tchatters,
        ]);
    }
}
