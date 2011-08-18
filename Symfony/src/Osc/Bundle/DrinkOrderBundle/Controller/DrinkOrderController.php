<?php

namespace Osc\Bundle\DrinkOrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Osc\Bundle\DrinkOrderBundle\Entity\DrinkOrder;

class DrinkOrderController extends Controller
{
    public function productAction()
    {
        if (!$this->container->get('session')->has('drinkOrder')) {
            $this->container->get('session')->set('drinkOrder', new DrinkOrder());
        }
        $form = $this->createFormBuilder($this->container->get('session')->get('drinkOrder'))
            ->add('product_id', 'choice', array( 'choices' => array('1' => 'BlueBull 128個入ケース', '2' => 'GreenBull 128個入ケース')))
            ->add('quantity', 'text')
            ->getForm();
        return $this->render('OscDrinkOrderBundle:DrinkOrder:product.html.twig', array('form' => $form->createView()));
    }

    public function productPostAction()
    {
        $form = $this->createFormBuilder($this->container->get('session')->get('drinkOrder'))
            ->add('product_id', 'choice', array( 'choices' => array('1' => 'BlueBull 128個入ケース', '2' => 'GreenBull 128個入ケース')))
            ->add('quantity', 'text')
            ->getForm();
        $form->bindRequest($this->getRequest());
        return $this->redirect($this->generateUrl('OscDrinkOrderBundle_address'));
    }

    public function addressAction()
    {
        $form = $this->createFormBuilder($this->container->get('session')->get('drinkOrder'))
            ->add('name', 'text')
            ->add('address', 'text')
            ->add('phone', 'text')
            ->getForm();
        return $this->render('OscDrinkOrderBundle:DrinkOrder:address.html.twig', array('form' => $form->createView()));
    }

    public function addressPostAction()
    {
        $form = $this->createFormBuilder($this->container->get('session')->get('drinkOrder'))
            ->add('name', 'text')
            ->add('address', 'text')
            ->add('phone', 'text')
            ->getForm();
        $form->bindRequest($this->getRequest());
        return $this->redirect($this->generateUrl('OscDrinkOrderBundle_confirmation'));
    }

    public function confirmationAction()
    {
        $form = $this->createFormBuilder($this->container->get('session')->get('drinkOrder'))->getForm();
        return $this->render('OscDrinkOrderBundle:DrinkOrder:confirmation.html.twig', array(
            'form' => $form->createView(),
            'drinkOrder' => $this->container->get('session')->get('drinkOrder')
        ));
    }

    public function confirmationPostAction()
    {
        $form = $this->createFormBuilder($this->container->get('session')->get('drinkOrder'))->getForm();
        $form->bindRequest($this->getRequest());
        $this->container->get('session')->remove('drinkOrder');
        return $this->redirect($this->generateUrl('OscDrinkOrderBundle_success'));
    }

    public function successAction()
    {
        return $this->render('OscDrinkOrderBundle:DrinkOrder:success.html.twig');
    }
}
