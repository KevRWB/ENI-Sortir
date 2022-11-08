<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
class EventFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $patinoireRennes = new Event();
        $patinoireRennes->setName('Blizz Rennes');
        $patinoireRennes->setStartDate(new \DateTime( '2022-11-30 12:00:00'));
        $patinoireRennes->setDuration(new \DateTime('01:45:00'));
        $patinoireRennes->setSubscriptionLimit(new \DateTime( '2022-11-29 12:00:00'));
        $patinoireRennes->setMaxUsers(5);
        $patinoireRennes->setInfos('Super sortie à la patinoire');
        $patinoireRennes->setOrganizater($this->getReference('jesse'));
        $patinoireRennes->setState($this->getReference('opened'));
        $patinoireRennes->setCampus($this->getReference('campus-rennes'));
        $patinoireRennes->setLocation($this->getReference('patinoire-rennes'));
        $patinoireRennes->addGoer($this->getReference('eliot'));
        $patinoireRennes->addGoer($this->getReference('roman'));
        $patinoireRennes->addGoer($this->getReference('alan'));
        $patinoireRennes->addGoer($this->getReference('maxime'));
        $manager->persist($patinoireRennes);

        $laserRennes = new Event();
        $laserRennes->setName('Laser game Rennes');
        $laserRennes->setStartDate(new \DateTime( '2022-11-05 12:00:00'));
        $laserRennes->setDuration(new \DateTime('01:15:30'));
        $laserRennes->setSubscriptionLimit(new \DateTime( '2022-11-04 12:00:00'));
        $laserRennes->setMaxUsers(6);
        $laserRennes->setInfos('Pan pan piou piou');
        $laserRennes->setOrganizater($this->getReference('kevin'));
        $laserRennes->setState($this->getReference('opened'));
        $laserRennes->setCampus($this->getReference('campus-rennes'));
        $laserRennes->setLocation($this->getReference('laser-rennes'));
        $laserRennes->addGoer($this->getReference('jesse'));
        $laserRennes->addGoer($this->getReference('emerick'));
        $laserRennes->addGoer($this->getReference('axelle'));
        $laserRennes->addGoer($this->getReference('marcela'));
        $manager->persist($laserRennes);

        $machinesNantes = new Event();
        $machinesNantes->setName('Les machines de l\ile');
        $machinesNantes->setStartDate(new \DateTime( '2022-11-10 17:00:00'));
        $machinesNantes->setDuration(new \DateTime('2:30:00'));
        $machinesNantes->setSubscriptionLimit(new \DateTime('2022-11-09 17:00:00'));
        $machinesNantes->setMaxUsers(4);
        $machinesNantes->setInfos('Sortie Chill');
        $machinesNantes->setOrganizater($this->getReference('marcela'));
        $machinesNantes->setState($this->getReference('opened'));
        $machinesNantes->setCampus($this->getReference('campus-nantes'));
        $machinesNantes->setLocation($this->getReference('machines-nantes'));
        $machinesNantes->addGoer($this->getReference('kevin'));
        $machinesNantes->addGoer($this->getReference('roman'));
        $machinesNantes->addGoer($this->getReference('eliot'));
        $manager->persist($machinesNantes);

        $crapaNantes = new Event();
        $crapaNantes->setName('Sortie CRAPA de Nantes');
        $crapaNantes->setStartDate(new \DateTime( '2022-11-12 19:30:00'));
        $crapaNantes->setDuration(new \DateTime('02:00:00'));
        $crapaNantes->setSubscriptionLimit(new \DateTime( '2022-11-11 19:30:00'));
        $crapaNantes->setMaxUsers(4);
        $crapaNantes->setInfos('Go sport');
        $crapaNantes->setOrganizater($this->getReference('eliot'));
        $crapaNantes->setState($this->getReference('opened'));
        $crapaNantes->setCampus($this->getReference('campus-nantes'));
        $crapaNantes->setLocation($this->getReference('parc-crapa-nantes'));
        $crapaNantes->addGoer($this->getReference('alan'));
        $crapaNantes->addGoer($this->getReference('maxime'));
        $manager->persist($crapaNantes);

        $stangalaQuimper = new Event();
        $stangalaQuimper->setName('Visite des gorges de Stangala');
        $stangalaQuimper->setStartDate(new \DateTime( '2022-11-07 09:00:00'));
        $stangalaQuimper->setDuration(new \DateTime('02:00:00'));
        $stangalaQuimper->setSubscriptionLimit(new \DateTime( '2022-11-06 09:00:00'));
        $stangalaQuimper->setMaxUsers(4);
        $stangalaQuimper->setInfos('Hop hop hop on marche');
        $stangalaQuimper->setOrganizater($this->getReference('axelle'));
        $stangalaQuimper->setState($this->getReference('created'));
        $stangalaQuimper->setCampus($this->getReference('campus-quimper'));
        $stangalaQuimper->setLocation($this->getReference('stangala-quimper'));
        $manager->persist($stangalaQuimper);

        $golfQuimper = new Event();
        $golfQuimper->setName('Golf de quimper');
        $golfQuimper->setStartDate(new \DateTime( '2022-10-15 09:00:00'));
        $golfQuimper->setDuration(new \DateTime('02:00:00'));
        $golfQuimper->setSubscriptionLimit(new \DateTime( '2022-10-14 09:00:00'));
        $golfQuimper->setMaxUsers(4);
        $golfQuimper->setInfos('bing, dans l trou');
        $golfQuimper->setOrganizater($this->getReference('roman'));
        $golfQuimper->setState($this->getReference('passed'));
        $golfQuimper->setCampus($this->getReference('campus-quimper'));
        $golfQuimper->setLocation($this->getReference('golf-quimper'));
        $crapaNantes->addGoer($this->getReference('alan'));
        $crapaNantes->addGoer($this->getReference('maxime'));
        $manager->persist($golfQuimper);

        $donjonNiort = new Event();
        $donjonNiort->setName('Musée du donjon');
        $donjonNiort->setStartDate(new \DateTime( '2022-11-01 09:00:00'));
        $donjonNiort->setDuration(new \DateTime('24:00:00'));
        $donjonNiort->setSubscriptionLimit(new \DateTime( '2022-10-30 09:00:00'));
        $donjonNiort->setMaxUsers(4);
        $donjonNiort->setInfos('Vivre dans in dooonjooonnn');
        $donjonNiort->setOrganizater($this->getReference('kevin'));
        $donjonNiort->setState($this->getReference('inProgress'));
        $donjonNiort->setCampus($this->getReference('campus-niort'));
        $donjonNiort->setLocation($this->getReference('donjon-niort'));
        $donjonNiort->addGoer($this->getReference('jesse'));
        $donjonNiort->addGoer($this->getReference('eliot'));
        $donjonNiort->addGoer($this->getReference('marcela'));
        $manager->persist($donjonNiort);

        $agesciNiort = new Event();
        $agesciNiort->setName('Visite du musée d\'Agesci');
        $agesciNiort->setStartDate(new \DateTime( '2022-11-15 09:00:00'));
        $agesciNiort->setDuration(new \DateTime('00:30:00'));
        $agesciNiort->setSubscriptionLimit(new \DateTime( '2022-11-14 09:00:00'));
        $agesciNiort->setMaxUsers(2);
        $agesciNiort->setInfos('Bah oui, encore un musée...');
        $agesciNiort->setOrganizater($this->getReference('axelle'));
        $agesciNiort->setState($this->getReference('passed'));
        $agesciNiort->setCampus($this->getReference('campus-niort'));
        $agesciNiort->setLocation($this->getReference('agesci-niort'));
        $manager->persist($agesciNiort);


        $faker = Faker\Factory::create('fr_FR');

        $events = Array();

        for($i=0; $i<20; $i++){
            $events[$i] = new Event();
            $events[$i]->setName($faker->word);
            $events[$i]->setStartDate(new \DateTime( '2022-11-9 09:00:00'));
            $events[$i]->setDuration(new \DateTime('00:30:00'));
            $events[$i]->setSubscriptionLimit(new \DateTime( '2022-11-8 09:00:00'));
            $events[$i]->setMaxUsers($faker->numberBetween(2, 50));
            $events[$i]->setInfos($faker->word);
            $events[$i]->setOrganizater($this->getReference('axelle'));
            $events[$i]->setState($this->getReference('opened'));
            $events[$i]->setCampus($this->getReference('campus-quimper'));
            $events[$i]->setLocation($this->getReference('golf-quimper'));
            $manager->persist($events[$i]);
            $this->addReference('event'.$i, $events[$i]);
        }

        for($i=20; $i<40; $i++){
            $events[$i] = new Event();
            $events[$i]->setName($faker->word);
            $events[$i]->setStartDate(new \DateTime( '2022-11-10 09:00:00'));
            $events[$i]->setDuration(new \DateTime('00:50:00'));
            $events[$i]->setSubscriptionLimit(new \DateTime( '2022-11-9 09:00:00'));
            $events[$i]->setMaxUsers($faker->numberBetween(2, 50));
            $events[$i]->setInfos($faker->word);
            $events[$i]->setOrganizater($this->getReference('jesse'));
            $events[$i]->setState($this->getReference('opened'));
            $events[$i]->setCampus($this->getReference('campus-rennes'));
            $events[$i]->setLocation($this->getReference('patinoire-rennes'));
            $manager->persist($events[$i]);
            $this->addReference('event'.$i, $events[$i]);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class, LocationFixtures::class, CampusFixtures::class, StateFixtures::class];
    }

}
