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
    #[Route('user/monProfil', name: 'profil')]
    public function monProfil(Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = new User();

        $profilForm = $this->createForm(ProfilType::class, $user );
        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted() && $profilForm->isValid()){

        }

        return $this->render('user/monProfil.html.twig', [
            'profilForm' => $profilForm->createView(),
        ]);
    }

    #[Route('/profil/{pseudo}', name: 'profil')]
    public function userName(UserRepository $userRepository,string $pseudo): Response
    {
        $user = $userRepository->findOneBy(['pseudo'=>$pseudo]);

        if ($user === null) {
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }

}