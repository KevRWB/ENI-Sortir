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
    #[Route('/profil', name: 'profil')]
    public function index(Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = new User();

        $profilForm = $this->createForm(ProfilType::class, $user );
        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted() && $profilForm->isValid()){

        }

        return $this->render('user/profil.html.twig', [
            'profilForm' => $profilForm->createView(),
        ]);
    }
}
