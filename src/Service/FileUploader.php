<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(private string $targetDirectory, private SluggerInterface $slugger, private Security $security)
    {

    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        //Récupère le chemin complet de la photo
        $image = $this->getTargetDirectory().'/'.$this->security->getUser()->getProfilePicture();

        try {

            //Si une image déjà existante
            if ($this->security->getUser()->getProfilePicture()){
                $this->security->getUser()->setProfilePicture(''); //ici pour vider le nom de mon fichier dans mon entité
                unlink($image); //ici je supprime le fichier
            }


            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}