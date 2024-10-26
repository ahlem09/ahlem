<?php

namespace App\Controller;

use App\Entity\TheatrePlay;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TheatrePlayController extends AbstractController
{
    #[Route('/theatreplays', name: 'theatre_play_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les pièces de théâtre triées par titre (ordre décroissant)
        $theatrePlaysByTitle = $entityManager->createQueryBuilder()
            ->select('tp')
            ->from(TheatrePlay::class, 'tp')
            ->orderBy('tp.title', 'DESC') // Ordre décroissant par titre
            ->getQuery()
            ->getResult();

        // Récupérer les pièces de théâtre triées par durée (ordre décroissant)
        $theatrePlaysByDuration = $entityManager->createQueryBuilder()
            ->select('tp')
            ->from(TheatrePlay::class, 'tp')
            ->orderBy('tp.duration', 'DESC') // Ordre décroissant par durée
            ->getQuery()
            ->getResult();

        return $this->render('theatre_play/display.html.twig', [
            'theatrePlaysByTitle' => $theatrePlaysByTitle,
            'theatrePlaysByDuration' => $theatrePlaysByDuration,
        ]);
    }

    #[Route('/theatreplays/delete/{id}', name: 'delete_theatre_play')]
    public function deleteTheatrePlay(int $id, EntityManagerInterface $entityManager): Response
    {
        // Chercher la pièce de théâtre par son ID
        $play = $entityManager->getRepository(TheatrePlay::class)->find($id);
        
        if ($play) {
            // Si la pièce est trouvée, la supprimer
            $entityManager->remove($play);
            $entityManager->flush();
            // Ajouter un message flash de succès
            $this->addFlash('success', 'Pièce de théâtre supprimée avec succès.');
        } else {
            // Si la pièce n'est pas trouvée, ajouter un message d'erreur
            $this->addFlash('error', 'Pièce de théâtre introuvable.');
        }

        // Rediriger vers la liste des pièces de théâtre
        return $this->redirectToRoute('theatre_play_list');
    }

    #[Route('/theatreplays/total/{id}', name: 'total_show_number')]
    public function TotalNumber(int $id, EntityManagerInterface $entityManager): Response
    {
        // Requête DQL pour compter le nombre total de spectacles pour une pièce de théâtre donnée
        $query = $entityManager->createQuery(
            'SELECT COUNT(s) 
            FROM App\Entity\Show s 
            WHERE s.theatrePlay = :id'
        )->setParameter('id', $id);

        $totalShows = $query->getSingleScalarResult();

        // Renvoyer la réponse (vous pouvez le rendre dans un template ou simplement le retourner)
        return new Response('Total number of shows for theatre play ID ' . $id . ': ' . $totalShows);
    }
}
