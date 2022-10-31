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
        $patinoireRennes->setName('Sortie blizz Rennes');
        $patinoireRennes->setStartDate(new \DateTime( '2022-11-30 12:00:00'));
        $patinoireRennes->setDuration(new Time('00:02:00'));
        $patinoireRennes->setSubscriptionLimit(new \DateTime( '2022-11-29 12:00:00'));
        $patinoireRennes->setMaxUsers(8);
        $patinoireRennes->setInfos('qmsdlfgkjqmfdgklhmkdfglhmskdf');
        $patinoireRennes->setState($this->getReference('opened'));
        $patinoireRennes->setCampus($this->getReference('campus-rennes'));

        $manager->persist($patinoireRennes);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class, LocationFixtures::class, CampusFixtures::class];
    }

}
