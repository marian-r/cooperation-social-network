<?php

namespace Symfony\Bundle\SecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
    }

    public function testTest()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/test');
    }

}
