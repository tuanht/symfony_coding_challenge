<?php

namespace Tuan\HotelBundle\Services;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class RoomFinder
{
    public function crawl(\DateTime $date)
    {
        $checkinDate =  $date->format('d/m/Y');
        $date->modify('+1 day');
        $checkoutDate = $date->format('d/m/Y');

        $client = new Client();
        $crawler = $client->request('GET',
            sprintf('http://www.hotels.com/ho555246/the-reverie-residence-ho-chi-minh-city-vietnam/?q-localised-check-in=%s&q-localised-check-out=%s',
                urlencode($checkinDate),
                urlencode($checkoutDate)));

        $rooms = $crawler->filter('.room-info > h3')->each(function (Crawler $node, $i) {
            return $node->text();
        });

        return $rooms;
    }
}
