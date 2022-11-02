<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/monProfil', name: 'profil')]
    public function monProfil(Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = new User();

        $profilForm = $this->createForm(ProfilType::class, $user );
        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted() && $profilForm->isValid()){

        }

        return $this->render('monProfil.html.twig', [
            'profilForm' => $profilForm->createView(),
        ]);
    }
}
