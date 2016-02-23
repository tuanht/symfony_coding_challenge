<?php

namespace Tuan\HotelBundle\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tuan\HotelBundle\Services\OfferManager;
use Tuan\HotelBundle\Services\RoomFinder;

class OfferController
{
    /**
     * @var ViewHandler
     */
    protected $viewHandler;

    /**
     * @var OfferManager
     */
    private $manager;

    /**
     * @var RoomFinder
     */
    private $roomFinder;

    public function __construct(ViewHandler $viewHandler, $manager, $roomFinder)
    {
        $this->viewHandler = $viewHandler;
        $this->manager = $manager;
        $this->roomFinder = $roomFinder;
    }

    public function addOfferAction(Request $request)
    {
        $checkInDate = date_create_from_format('Y-m-d', $request->get('date'));

        if (!$checkInDate) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $rooms = $this->roomFinder->crawl($checkInDate);
        $this->manager->create($checkInDate, $rooms);

        $resp = $this->getResponseData($request->get('date'), $rooms);
        $view = View::create($resp)
            ->setTemplate("TuanHotelBundle:Offer:add.html.twig")
            ->setTemplateVar($resp)
        ;

        return $this->viewHandler->handle($view);
    }

    public function removeOfferAction($id)
    {
        $offer = $this->manager->find($id);

        if (!$offer) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->manager->remove($offer);

        return new Response();
    }

    /**
     * @param string $date
     * @param array $rooms
     * @return array
     */
    private function getResponseData($date, $rooms)
    {
        return [
            'data' => [
                'date' => $date,
                'rooms' => $rooms
            ]
        ];
    }
}
