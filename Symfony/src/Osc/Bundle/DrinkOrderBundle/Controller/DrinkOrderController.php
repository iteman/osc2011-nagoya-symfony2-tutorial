<?php

namespace Osc\Bundle\DrinkOrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DrinkOrderController extends Controller
{
    public function productAction()
    {
        return $this->render('OscDrinkOrderBundle:DrinkOrder:product.html.twig');
    }
}
