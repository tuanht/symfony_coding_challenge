<?php

namespace Tuan\HotelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Tuan\HotelBundle\Entity\Offer;

class OfferControllerTest extends WebTestCase
{
    public function testAddAcceptJson()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/offers',
            ['date' => '2016-02-27'],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertStringStartsWith('application/json', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testAddAcceptHtml()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/offers',
            ['date' => '2016-02-28'],
            [],
            ['HTTP_ACCEPT' => 'text/html']
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertStringStartsWith('text/html', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testAddBadRequest()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/offers',
            ['date' => 'abc']
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testRemoveSuccess()
    {
        $client = static::createClient();

        /** @var Offer[] $offers */
        $offers = $client->getContainer()->get('tuan_hotel.offer_manager')->findAll();

        $client->request('DELETE', sprintf('/api/offers/%s', $offers[0]->getId()));
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testRemoveNotFound()
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/offers/999');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
