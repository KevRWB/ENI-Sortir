<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher){

    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setPseudo('admin');
        $admin->setFirstName('admin');
        $admin->setLastName('Istrateur');
        $admin->setPhoneNumber('0611111111');
        $admin->setEmail('admin@admin.com');
        $admin->setPassword($this->hasher->hashPassword( $admin, 'admin'));
        $admin->setIsActive(true);
        $admin->setIsAdmin(true);
        $roles[] = 'ROLE_ADMIN';
        $admin->setRoles($roles);
        $admin->setCampus($this->getReference('campus-rennes'));
        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $jesse = new User();
        $jesse->setPseudo('jesse');
        $jesse->setFirstName('Jesse');
        $jesse->setLastName('Vankerrbrouck');
        $jesse->setPhoneNumber('0611111111');
        $jesse->setEmail('jesse@jesse.com');
        $jesse->setPassword($this->hasher->hashPassword( $admin, 'jesse'));
        $jesse->setIsActive(true);
        $jesse->setIsAdmin(false);
        $jesse->setCampus($this->getReference('campus-rennes'));
        $jesse->setProfilePicture("Jesse-profile-636a5d076ba04-636b650911041.png");
        $manager->persist($jesse);
        $this->addReference('jesse', $jesse);

        $emerick = new User();
        $emerick->setPseudo('emerick');
        $emerick->setFirstName('Emerick');
        $emerick->setLastName('Levieil');
        $emerick->setPhoneNumber('0611111111');
        $emerick->setEmail('emerick@emerick.com');
        $emerick->setPassword($this->hasher->hashPassword( $admin, 'emerick'));
        $emerick->setIsActive(true);
        $emerick->setIsAdmin(false);
        $emerick->setCampus($this->getReference('campus-quimper'));
        $manager->persist($emerick);
        $this->addReference('emerick', $emerick);

        $kevin = new User();
        $kevin->setPseudo('kevin');
        $kevin->setFirstName('Kevin');
        $kevin->setLastName('Renault');
        $kevin->setPhoneNumber('069999999');
        $kevin->setEmail('kevin@kevin.com');
        $kevin->setPassword($this->hasher->hashPassword( $admin, 'kevin'));
        $kevin->setIsActive(true);
        $kevin->setIsAdmin(false);
        $kevin->setCampus($this->getReference('campus-niort'));
        $kevin->setProfilePicture("Kevin-636b65477818d.png");
        $manager->persist($kevin);
        $this->addReference('kevin', $kevin);

        $maxime = new User();
        $maxime->setPseudo('maxime');
        $maxime->setFirstName('Maxime');
        $maxime->setLastName('Rousseau');
        $maxime->setPhoneNumber('069999999');
        $maxime->setEmail('maxime@maxime.com');
        $maxime->setPassword($this->hasher->hashPassword( $admin, 'maxime'));
        $maxime->setIsActive(true);
        $maxime->setIsAdmin(false);
        $maxime->setCampus($this->getReference('campus-nantes'));
        $maxime->setProfilePicture("Max-profile-636a6e3778fa2-636b65885848e.png");
        $manager->persist($maxime);
        $this->addReference('maxime', $maxime);

        $alan = new User();
        $alan->setPseudo('alan');
        $alan->setFirstName('Alan');
        $alan->setLastName('Marzin');
        $alan->setPhoneNumber('069999999');
        $alan->setEmail('alan@alan.com');
        $alan->setPassword($this->hasher->hashPassword( $admin, 'alan'));
        $alan->setIsActive(true);
        $alan->setIsAdmin(false);
        $alan->setCampus($this->getReference('campus-nantes'));
        $manager->persist($alan);
        $this->addReference('alan', $alan);

        $roman = new User();
        $roman->setPseudo('roman');
        $roman->setFirstName('Roman');
        $roman->setLastName('Sueur');
        $roman->setPhoneNumber('069999999');
        $roman->setEmail('roman@roman.com');
        $roman->setPassword($this->hasher->hashPassword( $admin, 'roman'));
        $roman->setIsActive(true);
        $roman->setIsAdmin(false);
        $roman->setCampus($this->getReference('campus-rennes'));
        $roman->setProfilePicture("Roman-636b65701a2c0.png");
        $manager->persist($roman);
        $this->addReference('roman', $roman);

        $eliot = new User();
        $eliot->setPseudo('eliot');
        $eliot->setFirstName('Eliot');
        $eliot->setLastName('Galle');
        $eliot->setPhoneNumber('069999999');
        $eliot->setEmail('eliot@eliot.com');
        $eliot->setPassword($this->hasher->hashPassword( $admin, 'eliot'));
        $eliot->setIsActive(true);
        $eliot->setIsAdmin(false);
        $eliot->setCampus($this->getReference('campus-rennes'));
        $manager->persist($eliot);
        $this->addReference('eliot', $eliot);

        $marcela = new User();
        $marcela->setPseudo('marcela');
        $marcela->setFirstName('Dorel');
        $marcela->setLastName('Galle');
        $marcela->setPhoneNumber('069999999');
        $marcela->setEmail('marcela@marcela.com');
        $marcela->setPassword($this->hasher->hashPassword( $admin, 'marcela'));
        $marcela->setIsActive(true);
        $marcela->setIsAdmin(false);
        $marcela->setCampus($this->getReference('campus-nantes'));
        $marcela->setProfilePicture("Marcela-636b66275bb61.png");
        $manager->persist($marcela);
        $this->addReference('marcela', $marcela);

        $axelle = new User();
        $axelle->setPseudo('axelle');
        $axelle->setFirstName('Axelle');
        $axelle->setLastName('Cardin');
        $axelle->setPhoneNumber('069999999');
        $axelle->setEmail('axelle@axelle.com');
        $axelle->setPassword($this->hasher->hashPassword( $admin, 'axelle'));
        $axelle->setIsActive(true);
        $axelle->setIsAdmin(false);
        $axelle->setCampus($this->getReference('campus-nantes'));
        $axelle->setProfilePicture("Axelle-636b65577b8fc.png");
        $manager->persist($axelle);
        $this->addReference('axelle', $axelle);

        $faker = Faker\Factory::create('fr_FR');

        $users = Array();
        for($i=0; $i<20; $i++){
            $users[$i] = new User();
            $users[$i]->setPseudo($faker->firstName.$i);
            $users[$i]->setFirstName($faker->firstName);
            $users[$i]->setLastName($faker->lastName);
            $users[$i]->setPhoneNumber(666666);
            $users[$i]->setEmail($faker->email);
            $users[$i]->setPassword($this->hasher->hashPassword( $admin, 'user'));
            $users[$i]->setIsActive(true);
            $users[$i]->setIsAdmin(false);
            $users[$i]->setCampus($this->getReference('campus-nantes'));
            $manager->persist($users[$i]);
            $this->addReference('users'.$i, $users[$i]);
        }

        for($i=20; $i<40; $i++){
            $users[$i] = new User();
            $users[$i]->setPseudo($faker->firstName.$i);
            $users[$i]->setFirstName($faker->firstName);
            $users[$i]->setLastName($faker->lastName);
            $users[$i]->setPhoneNumber(666666);
            $users[$i]->setEmail($faker->email);
            $users[$i]->setPassword($this->hasher->hashPassword( $admin, 'user'));
            $users[$i]->setIsActive(true);
            $users[$i]->setIsAdmin(true);
            $users[$i]->setCampus($this->getReference('campus-rennes'));
            $manager->persist($users[$i]);
            $this->addReference('users'.$i, $users[$i]);
        }

        for($i=40; $i<60; $i++){
            $users[$i] = new User();
            $users[$i]->setPseudo($faker->firstName.$i);
            $users[$i]->setFirstName($faker->firstName);
            $users[$i]->setLastName($faker->lastName);
            $users[$i]->setPhoneNumber(666666);
            $users[$i]->setEmail($faker->email);
            $users[$i]->setPassword($this->hasher->hashPassword( $admin, 'user'));
            $users[$i]->setIsActive(true);
            $users[$i]->setIsAdmin(false);
            $users[$i]->setCampus($this->getReference('campus-niort'));
            $manager->persist($users[$i]);
            $this->addReference('users'.$i, $users[$i]);
        }

        for($i=60; $i<80; $i++){
            $users[$i] = new User();
            $users[$i]->setPseudo($faker->firstName.$i);
            $users[$i]->setFirstName($faker->firstName);
            $users[$i]->setLastName($faker->lastName);
            $users[$i]->setPhoneNumber(666666);
            $users[$i]->setEmail($faker->email);
            $users[$i]->setPassword($this->hasher->hashPassword( $admin, 'user'));
            $users[$i]->setIsActive(true);
            $users[$i]->setIsAdmin(false);
            $users[$i]->setCampus($this->getReference('campus-quimper'));
            $manager->persist($users[$i]);
            $this->addReference('users'.$i, $users[$i]);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampusFixtures::class];
    }
}
