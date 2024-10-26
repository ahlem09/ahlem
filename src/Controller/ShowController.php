<?php

// src/Controller/ShowController.php
namespace App\Controller;

use App\Entity\Show;
use App\Entity\TheatrePlay;
use App\Form\ShowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route('/show/new/{theatrePlayId}', name: 'add_show')]
    public function new(int $theatrePlayId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $theatrePlay = $entityManager->getRepository(TheatrePlay::class)->find($theatrePlayId);

        if (!$theatrePlay) {
            throw $this->createNotFoundException('ThéâtrePlay non trouvé.');
        }

        $show = new Show();
        $show->setTheatrePlay($theatrePlay);

        // Initialiser le nombre de places à 30
        $show->setNbrSeat(30); // Assurez-vous que cette méthode existe dans votre entité Show.

        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($show);
            $entityManager->flush();

            return $this->redirectToRoute('theatre_play_list'); // Assurez-vous que cette route existe
        }

        return $this->render('show/new.html.twig', [
            'form' => $form->createView(),
            'theatrePlay' => $theatrePlay,
        ]);
    }
}
