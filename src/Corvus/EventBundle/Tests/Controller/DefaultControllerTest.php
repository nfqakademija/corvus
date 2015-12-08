<?php

namespace Corvus\EventBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    public function testRemindDebtsAction(){
        $client = static::createClient();

        $client->request('GET', '/remind/1');

        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testCreateEventAction(){

        $client = static::createClient();

        $client->request('GET', '/event/new', array(), array(), array(
            'PHP_AUTH_USER' => 'username',
            'PHP_AUTH_PW'   => 'pa$$word',
        ));

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

}