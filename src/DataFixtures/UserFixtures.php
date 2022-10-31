<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher){

    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setPseudo('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setPassword('admin');
        $admin->setIsActive(true);
        $admin->setIsAdmin(true);
        $admin->setCampus($this->getReference('campus-rennes'));
        $manager->persist($admin);

        $jesse = new User();
        $jesse->setPseudo('jesse');
        $jesse->setEmail('jesse@jesse.com');
        $jesse->setPassword('jesse');
        $jesse->setIsActive(true);
        $jesse->setIsAdmin(false);
        $jesse->setCampus($this->getReference('campus-rennes'));
        $manager->persist($jesse);

        $emerick = new User();
        $emerick->setPseudo('emerick');
        $emerick->setEmail('emerick@emerick.com');
        $emerick->setPassword('emerick');
        $emerick->setIsActive(true);
        $emerick->setIsAdmin(false);
        $emerick->setCampus($this->getReference('campus-quimper'));
        $manager->persist($emerick);

        $kevin = new User();
        $kevin->setPseudo('kevin');
        $kevin->setEmail('kevin@kevin.com');
        $kevin->setPassword('kevin');
        $kevin->setIsActive(true);
        $kevin->setIsAdmin(false);
        $kevin->setCampus($this->getReference('campus-niort'));
        $manager->persist($kevin);

        $maxime = new User();
        $maxime->setPseudo('maxime');
        $maxime->setEmail('maxime@maxime.com');
        $maxime->setPassword('maxime');
        $maxime->setIsActive(true);
        $maxime->setIsAdmin(false);
        $maxime->setCampus($this->getReference('campus-nantes'));
        $manager->persist($maxime);

        $alan = new User();
        $alan->setPseudo('alan');
        $alan->setEmail('alan@alan.com');
        $alan->setPassword('alan');
        $alan->setIsActive(true);
        $alan->setIsAdmin(false);
        $alan->setCampus($this->getReference('campus-nantes'));
        $manager->persist($alan);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampusFixtures::class];
    }
}
