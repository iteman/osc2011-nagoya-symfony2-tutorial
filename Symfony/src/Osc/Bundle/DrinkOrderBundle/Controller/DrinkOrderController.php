<?php

namespace Osc\Bundle\DrinkOrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Osc\Bundle\DrinkOrderBundle\Entity\DrinkOrder;

class DrinkOrderController extends Controller
{
    public function productAction()
    {
        $form = $this->createFormBuilder(new DrinkOrder())
            ->add('product_id', 'choice', array( 'choices' => array('1' => 'BlueBull 128個入ケース', '2' => 'GreenBull 128個入ケース')))
            ->add('quantity', 'text')
            ->getForm();
        return $this->render('OscDrinkOrderBundle:DrinkOrder:product.html.twig', array('form' => $form->createView()));
    }
}
