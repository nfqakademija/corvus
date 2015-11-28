<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/21/2015
 * Time: 20:35
 */

namespace Corvus\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Corvus\EventBundle\Entity\EventMail;

class LoadEventMailData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $eventMail1 = new EventMail();
        $eventMail1->setEvent($this->getReference('e1'));
        $eventMail1->setEmail("kazkas@google.com");

        $manager->persist($eventMail1);
        $manager->flush();

        $eventMail2 = new EventMail();
        $eventMail2->setEvent($this->getReference('e1'));
        $eventMail2->setEmail("kazkas_kitas@google.com");

        $manager->persist($eventMail2);
        $manager->flush();

        $eventMail3 = new EventMail();
        $eventMail3->setEvent($this->getReference('e2'));
        $eventMail3->setEmail("serioga@mail.ru");

        $manager->persist($eventMail3);
        $manager->flush();

        $eventMail4 = new EventMail();
        $eventMail4->setEvent($this->getReference('e2'));
        $eventMail4->setEmail("masha@mail.ru");

        $manager->persist($eventMail4);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}