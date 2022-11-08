<?php

namespace App\Controller;

use App\Form\ProfilType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $hasher){

    }


    #[Route('/monProfil', name: 'monProfil')]
    public function monProfil(Request $request,  EntityManagerInterface $em, UserRepository $userRepository,  FileUploader $fileUploader): Response
    {

        /**
         * @var  PasswordAuthenticatedUserInterface $loggedUser
         */
        $loggedUser = $this->getUser();

        $this->denyAccessUnlessGranted('ROLE_USER');

        $profilForm = $this->createForm(ProfilType::class, $loggedUser);
        $profilForm->handleRequest($request);



        if($profilForm->isSubmitted() && $profilForm->isValid()){

            if(!empty($profilForm->get('password2')->getData())){

                $loggedUser->setPassword($this->hasher->hashPassword($loggedUser, $profilForm->get('password2')->getData()));

            }
            /** @var UploadedFile $profilePicture */
            $profilePicture = $profilForm->get('profilePicture')->getData();
            if($profilePicture){
                $picture = $fileUploader->upload($profilePicture);
                $loggedUser->setProfilePicture($picture);
            }
            sleep(1.7);
            $em->persist($loggedUser);
            $em->flush();
        }

        return $this->render('user/monProfil.html.twig', [
            'profilForm' => $profilForm->createView(),
            'user' => $loggedUser,
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
