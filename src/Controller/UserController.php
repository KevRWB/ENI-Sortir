<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('user/profil.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
