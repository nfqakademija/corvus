<?php

/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 12/4/2015
 * Time: 14:56
 */

namespace Corvus\EventBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EventTimeoutCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('corvus:event:timeout')
            ->setDescription('Check events ordering time and suspend them if time is up');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $events = $em->getRepository('EventBundle:Event')->findBy(['status' => 1]);
        $timeNow = new \DateTime('now');
        foreach ($events as $event)
        {
            $endDate = $event->getEndDateTime();
            if ($endDate < $timeNow)
            {
                $event->setStatus(2);
                //$dispatcher = $this->getContainer()->get('event_dispatcher');
                //$dispatcher->dispatch(EventEvents::EVENT_TIMEOUT, new SendMailsEvent($event));
            }
        }
    }
}