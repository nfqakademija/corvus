<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/21/2015
 * Time: 20:13
 */

namespace Corvus\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Corvus\EventBundle\Entity\Event;

class LoadEventData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $event = new Event();
        $event->setTitle("Pietus");
        $event->setDealer($this->getReference('d1'));
        $event->setEndDateTime(new \DateTime("2015-11-30 14:30:00"));
        $event->setHost($this->getReference('u1'));
        $event->setIsDeleted(false);
        $event->setStatus(1);
        $event->addUser($this->getReference('u2'));
        $event->addUser($this->getReference('u3'));

        $manager->persist($event);
        $manager->flush();

        $event2 = new Event();
        $event2->setTitle("Vakariene");
        $event2->setDealer($this->getReference('d2'));
        $event2->setEndDateTime(new \DateTime("2015-11-29 16:30:00"));
        $event2->setHost($this->getReference('u3'));
        $event2->setIsDeleted(false);
        $event2->setStatus(1);
        $event2->addUser($this->getReference('u1'));

        $manager->persist($event2);
        $manager->flush();

        $this->addReference('e1', $event);
        $this->addReference('e2', $event2);
    }

    public function getOrder()
    {
        return 3;
    }
}