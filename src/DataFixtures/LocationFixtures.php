<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $crapa = new Location();
        $crapa->setName('Parc CRAPA');
        $crapa->setStreet('Rue du Pré-Salé');
        $crapa->setLatitude('47.219746742250756');
        $crapa->setLongitude('-1.5040284117821785');
        $crapa->setCity($this->getReference('city-nantes'));
        $manager->persist($crapa);
        $this->addReference('parc-crapa-nantes', $crapa);

        $machines = new Location();
        $machines->setName('Les Machines de l\'Île');
        $machines->setStreet('Boulevard Léon Bureau');
        $machines->setLatitude('47.211700432066976');
        $machines->setLongitude('-1.5481968353916553');
        $machines->setCity($this->getReference('city-nantes'));
        $manager->persist($machines);
        $this->addReference('machines-nantes', $machines);

        $blizz = new Location();
        $blizz->setName('Patinoire Le Blizz');
        $blizz->setStreet('8 Avenue des Gayeulles');
        $blizz->setLatitude('48.132798156271036');
        $blizz->setLongitude('-1.647422656360182');
        $blizz->setCity($this->getReference('city-rennes'));
        $manager->persist($blizz);
        $this->addReference('patinoire-rennes', $blizz);

        $laser = new Location();
        $laser->setName('Space Laser');
        $laser->setStreet('12 Rue Jules Vallès');
        $laser->setLatitude('48.105961907077216');
        $laser->setLongitude('-1.705084034749394');
        $laser->setCity($this->getReference('city-rennes'));
        $manager->persist($laser);
        $this->addReference('laser-rennes', $laser);

        $stangala = new Location();
        $stangala->setName('Gorges du Stangala');
        $stangala->setStreet('103 Route du Stangala');
        $stangala->setLatitude('48.030283271727754');
        $stangala->setLongitude('-4.047447994250477');
        $stangala->setCity($this->getReference('city-quimper'));
        $manager->persist($stangala);
        $this->addReference('stangala-quimper', $stangala);

        $golf = new Location();
        $golf->setName('Golf de Quimper');
        $golf->setStreet('90 allée de Lanniron');
        $golf->setLatitude('47.892486869088074');
        $golf->setLongitude('-4.052501946817509');
        $golf->setCity($this->getReference('city-quimper'));
        $manager->persist($golf);
        $this->addReference('golf-quimper', $golf);

        $donjon = new Location();
        $donjon->setName('Musée du Donjon');
        $donjon->setStreet('Rue du Guesclin');
        $donjon->setLatitude('46.32571641683182');
        $donjon->setLongitude('-0.46383040903641315');
        $donjon->setCity($this->getReference('city-niort'));
        $manager->persist($donjon);
        $this->addReference('donjon-niort', $donjon);

        $agesci = new Location();
        $agesci->setName('Musée Bernard d\'Agesci');
        $agesci->setStreet('26 Avenue de Limoges');
        $agesci->setLatitude('46.32182783076171');
        $agesci->setLongitude('-0.4510767343789234');
        $agesci->setCity($this->getReference('city-niort'));
        $manager->persist($agesci);
        $this->addReference('agesci-niort', $agesci);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CityFixtures::class];
    }
}
