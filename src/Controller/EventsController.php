<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    #[Route('/accueil', name: 'homepage')]
    public function accueil(Request $request): Response
    {

        $request->getSession()->getFlashBag()->add('note', 'Vous devez être connecté pour accéder au site');

        $this->denyAccessUnlessGranted('ROLE_USER');


        return $this->render('events/homepage.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }
}
