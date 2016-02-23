<?php

class RoomFinderTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    /** @var \Symfony\Component\DependencyInjection\Container $container */
    private $container;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

    public function testCrawl()
    {
        /** @var \Tuan\HotelBundle\Services\RoomFinder $finder */
        $finder = $this->container->get('tuan_hotel.room_finder');

        $date = date_create_from_format('Y-m-d', '2016-02-27');
        $this->assertGreaterThan(0, count($finder->crawl($date)));
    }
}
