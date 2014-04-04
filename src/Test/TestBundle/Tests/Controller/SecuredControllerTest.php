<?php

namespace Test\TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecuredControllerTest extends WebTestCase
{
    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add');
    }

    public function testRemove()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/remove');
    }

}
