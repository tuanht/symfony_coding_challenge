<?php

namespace Tuan\HotelBundle\Services;

use Doctrine\ORM\EntityManager;
use Tuan\HotelBundle\Entity\Offer;
use Tuan\HotelBundle\Entity\Room;

class OfferManager
{
    private $em;

    /**
     * @var EntityManager
     */
    private $offerRepo;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->offerRepo = $em->getRepository('TuanHotelBundle:Offer');
    }

    /**
     * @param integer|string $id
     * @return Offer
     */
    public function find($id)
    {
        return $this->offerRepo->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->offerRepo->findAll();
    }

    public function create(\DateTime $date, $rooms)
    {
        $offer = new Offer();
        $offer->setDate($date);
        foreach ($rooms as $room) {
            $offer->addRoom($this->newRoom($offer, $room));
        }
        $this->em->persist($offer);
        $this->em->flush();
    }

    public function remove(Offer $offer)
    {
        $this->em->remove($offer);
        $this->em->flush();
    }

    private function newRoom($offer, $name)
    {
        $room = new Room();
        $room->setOffer($offer);
        $room->setName($name);
        return $room;
    }
}
