<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Time;

class EventFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $patinoireRennes = new Event();
        $patinoireRennes->setName('Blizz Rennes');
        $patinoireRennes->setStartDate(new \DateTime( '2022-11-30 12:00:00'));
        $patinoireRennes->setDuration(new Time('00:02:00'));
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
        $laserRennes->setDuration(new Time('00:01:30'));
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
        $machinesNantes->setDuration(new Time('00:02:00'));
        $machinesNantes->setSubscriptionLimit(new \DateTime( '2022-11-09 17:00:00'));
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
        $crapaNantes->setDuration(new Time('00:02:00'));
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
        $stangalaQuimper->setDuration(new Time('00:02:00'));
        $stangalaQuimper->setSubscriptionLimit(new \DateTime( '2022-11-06 09:00:00'));
        $stangalaQuimper->setMaxUsers(4);
        $stangalaQuimper->setInfos('Hop hop hop on marche');
        $stangalaQuimper->setOrganizater($this->getReference('axelle'));
        $stangalaQuimper->setState($this->getReference('created'));
        $stangalaQuimper->setCampus($this->getReference('campus-quimper'));
        $stangalaQuimper->setLocation($this->getReference('stangala-quimper'));
        $manager->persist($stangalaQuimper);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class, LocationFixtures::class, CampusFixtures::class, StateFixtures::class];
    }

}
