<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $created = new State();
        $created->setLibelle('created');
        $manager->persist($created);
        $this->addReference('created', $created);

        $opened = new State();
        $opened->setLibelle('opened');
        $manager->persist($opened);
        $this->addReference('opened', $opened);

        $inProgress = new State();
        $inProgress->setLibelle('inProgress');
        $manager->persist($inProgress);
        $this->addReference('inProgress', $inProgress);

        $passed= new State();
        $passed->setLibelle('passed');
        $manager->persist($passed);
        $this->addReference('passed', $passed);

        $canceled = new State();
        $canceled->setLibelle('canceled');
        $manager->persist($canceled);
        $this->addReference('canceled', $canceled);

        $manager->flush();
    }
}
