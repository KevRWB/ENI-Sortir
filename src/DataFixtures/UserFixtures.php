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
        $this->addReference('admin', $admin);

        $jesse = new User();
        $jesse->setPseudo('jesse');
        $jesse->setEmail('jesse@jesse.com');
        $jesse->setPassword('jesse');
        $jesse->setIsActive(true);
        $jesse->setIsAdmin(false);
        $jesse->setCampus($this->getReference('campus-rennes'));
        $manager->persist($jesse);
        $this->addReference('jesse', $jesse);

        $emerick = new User();
        $emerick->setPseudo('emerick');
        $emerick->setEmail('emerick@emerick.com');
        $emerick->setPassword('emerick');
        $emerick->setIsActive(true);
        $emerick->setIsAdmin(false);
        $emerick->setCampus($this->getReference('campus-quimper'));
        $manager->persist($emerick);
        $this->addReference('emerick', $emerick);

        $kevin = new User();
        $kevin->setPseudo('kevin');
        $kevin->setEmail('kevin@kevin.com');
        $kevin->setPassword('kevin');
        $kevin->setIsActive(true);
        $kevin->setIsAdmin(false);
        $kevin->setCampus($this->getReference('campus-niort'));
        $manager->persist($kevin);
        $this->addReference('kevin', $kevin);

        $maxime = new User();
        $maxime->setPseudo('maxime');
        $maxime->setEmail('maxime@maxime.com');
        $maxime->setPassword('maxime');
        $maxime->setIsActive(true);
        $maxime->setIsAdmin(false);
        $maxime->setCampus($this->getReference('campus-nantes'));
        $manager->persist($maxime);
        $this->addReference('maxime', $maxime);

        $alan = new User();
        $alan->setPseudo('alan');
        $alan->setEmail('alan@alan.com');
        $alan->setPassword('alan');
        $alan->setIsActive(true);
        $alan->setIsAdmin(false);
        $alan->setCampus($this->getReference('campus-nantes'));
        $manager->persist($alan);
        $this->addReference('alan', $alan);

        $roman = new User();
        $roman->setPseudo('roman');
        $roman->setEmail('roman@roman.com');
        $roman->setPassword('roman');
        $roman->setIsActive(true);
        $roman->setIsAdmin(false);
        $roman->setCampus($this->getReference('campus-rennes'));
        $manager->persist($roman);
        $this->addReference('roman', $roman);

        $eliot = new User();
        $eliot->setPseudo('eliot');
        $eliot->setEmail('eliot@eliot.com');
        $eliot->setPassword('eliot');
        $eliot->setIsActive(true);
        $eliot->setIsAdmin(false);
        $eliot->setCampus($this->getReference('campus-rennes'));
        $manager->persist($eliot);
        $this->addReference('eliot', $eliot);

        $marcela = new User();
        $marcela->setPseudo('marcela');
        $marcela->setEmail('marcela@marcela.com');
        $marcela->setPassword('marcela');
        $marcela->setIsActive(true);
        $marcela->setIsAdmin(false);
        $marcela->setCampus($this->getReference('campus-nantes'));
        $manager->persist($marcela);
        $this->addReference('marcela', $marcela);

        $axelle = new User();
        $axelle->setPseudo('axelle');
        $axelle->setEmail('axelle@axelle.com');
        $axelle->setPassword('axelle');
        $axelle->setIsActive(true);
        $axelle->setIsAdmin(false);
        $axelle->setCampus($this->getReference('campus-nantes'));
        $manager->persist($axelle);
        $this->addReference('axelle', $axelle);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampusFixtures::class];
    }
}
