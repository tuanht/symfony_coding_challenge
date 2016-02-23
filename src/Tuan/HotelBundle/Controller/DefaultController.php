<?php

namespace Tuan\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TuanHotelBundle:Default:index.html.twig');
    }
}
