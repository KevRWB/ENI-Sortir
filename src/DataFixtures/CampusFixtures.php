<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //NANTES QUIMPER RENNES NIORT

        $campusNantes = new Campus();
        $campusNantes->setName('Nantes');
        $manager->persist($campusNantes);
        $this->addReference('campus-nantes', $campusNantes);


        $campusQuimper = new Campus();
        $campusQuimper->setName('Quimper');
        $manager->persist($campusQuimper);
        $this->addReference('campus-quimper', $campusQuimper);


        $campusRennes = new Campus();
        $campusRennes->setName('Rennes');
        $manager->persist($campusRennes);
        $this->addReference('campus-rennes', $campusRennes);

        $campusNiort = new Campus();
        $campusNiort->setName('Niort');
        $manager->persist($campusNiort);
        $this->addReference('campus-niort', $campusNiort);

        $manager->flush();
    }
}
