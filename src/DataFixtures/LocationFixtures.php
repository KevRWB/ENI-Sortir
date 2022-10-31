<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nantes = new Location();
        $nantes->setName('Parc-CRAPA');
        $nantes->setStreet('Rue-du-Pré-Salé');
        $nantes->setLatitude('47.219746742250756');
        $nantes->setLongitude('-1.5040284117821785');
        $nantes->setCity($this->getReference('Nantes'));
        $manager->persist($nantes);
        $this->addReference('location-nantes', $nantes);

        $nantes = new Location();
        $nantes->setName('Les-Machines-de-l\'Île');
        $nantes->setStreet('Parc-des-Chantiers,-Boulevard-Léon-Bureau');
        $nantes->setLatitude('47.211700432066976');
        $nantes->setLongitude('-1.5481968353916553');
        $manager->persist($nantes);
        $this->addReference('location-nantes', $nantes);

        $rennes = new Location();
        $rennes->setName('Patinoire-Le-Blizz');
        $rennes->setStreet('Avenue-des-Gayeulles');
        $rennes->setLatitude('48.132798156271036');
        $rennes->setLongitude('-1.647422656360182');
        $manager->persist($rennes);
        $this->addReference('location-rennes', $rennes);

        $rennes = new Location();
        $rennes->setName('Space-Laser');
        $rennes->setStreet('Rue Jules Vallès');
        $rennes->setLatitude('48.105961907077216');
        $rennes->setLongitude('-1.705084034749394');
        $manager->persist($rennes);
        $this->addReference('location-rennes', $rennes);

        $quimper = new Location();
        $quimper->setName('Gorges-du-Stangala');
        $quimper->setStreet('Route-du-Stangala');
        $quimper->setLatitude('48.030283271727754');
        $quimper->setLongitude('-4.047447994250477');
        $manager->persist($quimper);
        $this->addReference('location-quimper', $quimper);

        $quimper = new Location();
        $quimper->setName('Golf-Bluegreen-l\'Odet');
        $quimper->setStreet('Clohars-Fouesnant,-Bénodet');
        $quimper->setLatitude('47.892486869088074');
        $quimper->setLongitude('-4.052501946817509');
        $manager->persist($quimper);
        $this->addReference('location-quimper', $quimper);

        $niort = new Location();
        $niort->setName('Musée-du-Donjon');
        $niort->setStreet('Rue-du-Guesclin');
        $niort->setLatitude('46.32571641683182');
        $niort->setLongitude('-0.46383040903641315');
        $manager->persist($niort);
        $this->addReference('location-niort', $niort);

        $niort = new Location();
        $niort->setName('Musée-Bernard-d\'Agesci');
        $niort->setStreet('Avenue-de-Limoges');
        $niort->setLatitude('46.32182783076171');
        $niort->setLongitude('-0.4510767343789234');
        $manager->persist($niort);
        $this->addReference('location-niort', $niort);

        $manager->flush();
    }
}
