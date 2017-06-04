<?php

namespace ContactBookBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonControllerTest extends WebTestCase
{
    public function testShownewform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');
    }

    public function testCreatenew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');
    }

    public function testShoweditform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/modify');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/modify');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/delete');
    }

    public function testShowone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}');
    }

    public function testShowall()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

}
