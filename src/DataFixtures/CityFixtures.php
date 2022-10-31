<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nantes = new City();
        $nantes->setName('Nantes');
        $nantes->setCodePostal('44000');
        $manager->persist($nantes);
        $this->addReference('city-nantes', $nantes);

        $rennes = new City();
        $rennes->setName('Rennes');
        $rennes->setCodePostal('35000');
        $manager->persist($rennes);
        $this->addReference('city-rennes', $rennes);

        $quimper = new City();
        $quimper->setName('Quimper');
        $quimper->setCodePostal('29000');
        $manager->persist($quimper);
        $this->addReference('city-quimper', $quimper);

        $niort = new City();
        $niort->setName('Niort');
        $niort->setCodePostal('79000');
        $manager->persist($niort);
        $this->addReference('city-niort', $niort);

        $manager->flush();
    }
}
