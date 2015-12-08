<?php
use Corvus\EventBundle\Entity\Event;
use Corvus\EventBundle\EventEvents;
use Corvus\MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventAlteredListenerTest extends WebTestCase
{
    public function testListenerThatChangesEventStatus()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dispatcher = $container->get('event_dispatcher');

        $corvus_event = new Event();

        /*corvus event cant be without host*/
        $host = $this->getMock(User::class);
        $host->expects($this->once())
            ->method('getEmail')
            ->will($this->returnValue('host@host.gmail'));
        $corvus_event->setHost($host);

        $dispatcher->dispatch(EventEvents::EVENT_CREATED, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event));
        $this->assertEquals(1, $corvus_event->getStatus());

        $dispatcher->dispatch(EventEvents::EVENT_CANCEL, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event));
        $this->assertEquals(0, $corvus_event->getStatus());

        $dispatcher->dispatch(EventEvents::EVENT_NO_DEBTS, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event));
        $this->assertEquals(5, $corvus_event->getStatus());

        $dispatcher->dispatch(EventEvents::EVENT_SUSPEND, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event));
        $this->assertEquals(2, $corvus_event->getStatus());

        $dispatcher->dispatch(EventEvents::EVENT_FOOD_ORDERED, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event));
        $this->assertEquals(3, $corvus_event->getStatus());

        $dispatcher->dispatch(EventEvents::EVENT_TIMEOUT, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event));
        $this->assertEquals(2, $corvus_event->getStatus());

        $dispatcher->dispatch(EventEvents::EVENT_EDITED_TIME_EXTENDED, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event));
        $this->assertEquals(1, $corvus_event->getStatus());

        $dispatcher->dispatch(EventEvents::EVENT_FOOD_DELIVERED, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event));
        $this->assertGreaterThan(3, $corvus_event->getStatus());
        $this->assertLessThan(6, $corvus_event->getStatus());
    }

//    public function testMailIsSendWhenEventStatusChange()
//    {
//        $client = static::createClient();
//
//        // Enable the profiler for the next request (it does nothing if the profiler is not available)
//        $client->enableProfiler();
//        $container = $client->getContainer();
//        $dispatcher = $container->get('event_dispatcher');
//        $corvus_event = new Event();
//
//        $client->enableProfiler();
//        $profiler = $container->get('profiler');
//        $mailCollector = $profiler->get('swiftmailer');
//
//
//        $email = new \Corvus\EventBundle\Entity\EventMail();
//        $email->setEmail('corvusfood@gmail.com');
//        $dispatcher->dispatch(EventEvents::EVENT_CREATED, new \Corvus\EventBundle\Event\SendMailsEvent($corvus_event,null,$email));
//
//
//        $this->assertEquals(1, $mailCollector->getMessageCount());
//    }

}
