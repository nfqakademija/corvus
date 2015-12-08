<?php

namespace Corvus\EventBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{


    public function testRemindDebtsAction(){
        $client = static::createClient();

        $client->request('GET', '/remind/1');

        $this->assertTrue($client->getResponse()->isRedirect());
    }


}