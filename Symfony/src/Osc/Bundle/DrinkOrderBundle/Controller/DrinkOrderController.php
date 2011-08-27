<?php

namespace Osc\Bundle\DrinkOrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Osc\Bundle\DrinkOrderBundle\Entity\DrinkOrder;
use Osc\Bundle\DrinkOrderBundle\Form\Type\AddressDrinkOrderType;
use Osc\Bundle\DrinkOrderBundle\Form\Type\ProductDrinkOrderType;

class DrinkOrderController extends Controller
{
    const STATE_PRODUCT = 'STATE_PRODUCT';
    const STATE_ADDRESS = 'STATE_ADDRESS';
    const STATE_CONFIRMATION = 'STATE_CONFIRMATION';
    const STATE_SUCCESS = 'STATE_SUCCESS';

    public function productAction()
    {
        $this->container->get('session')->set('state', self::STATE_PRODUCT);

        if (!$this->container->get('session')->has('drinkOrder')) {
            $this->container->get('session')->set('drinkOrder', new DrinkOrder());
        }
        $form = $this->createForm(new ProductDrinkOrderType(), $this->container->get('session')->get('drinkOrder'));
        return $this->render('OscDrinkOrderBundle:DrinkOrder:product.html.twig', array('form' => $form->createView()));
    }

    public function productPostAction()
    {
        if (!($this->container->get('session')->has('state')
              && $this->container->get('session')->get('state') == self::STATE_PRODUCT)) {
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_product'));
        }

        $form = $this->createForm(
            new ProductDrinkOrderType(),
            $this->container->get('session')->get('drinkOrder'),
            array('validation_groups' => array('product'))
        );
        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
            $this->container->get('session')->set('state', self::STATE_ADDRESS);
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_address'));
        } else {
            return $this->render('OscDrinkOrderBundle:DrinkOrder:product.html.twig', array('form' => $form->createView()));
        }
    }

    public function addressAction()
    {
        if (!($this->container->get('session')->has('state')
              && ($this->container->get('session')->get('state') == self::STATE_ADDRESS
                  || $this->container->get('session')->get('state') == self::STATE_CONFIRMATION))) {
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_product'));
        }

        $this->container->get('session')->set('state', self::STATE_ADDRESS);

        $form = $this->createForm(new AddressDrinkOrderType(), $this->container->get('session')->get('drinkOrder'));
        return $this->render('OscDrinkOrderBundle:DrinkOrder:address.html.twig', array('form' => $form->createView()));
    }

    public function addressPostAction()
    {
        if (!($this->container->get('session')->has('state')
              && $this->container->get('session')->get('state') == self::STATE_ADDRESS)) {
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_product'));
        }

        $form = $this->createForm(
            new AddressDrinkOrderType(),
            $this->container->get('session')->get('drinkOrder'),
            array('validation_groups' => array('address'))
        );
        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
            $this->container->get('session')->set('state', self::STATE_CONFIRMATION);
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_confirmation'));
        } else {
            return $this->render('OscDrinkOrderBundle:DrinkOrder:address.html.twig', array('form' => $form->createView()));
        }
    }

    public function confirmationAction()
    {
        if (!($this->container->get('session')->has('state')
              && $this->container->get('session')->get('state') == self::STATE_CONFIRMATION)) {
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_product'));
        }

        $form = $this->createFormBuilder($this->container->get('session')->get('drinkOrder'))->getForm();
        return $this->render('OscDrinkOrderBundle:DrinkOrder:confirmation.html.twig', array(
            'form' => $form->createView(),
            'drinkOrder' => $this->container->get('session')->get('drinkOrder')
        ));
    }

    public function confirmationPostAction()
    {
        if (!($this->container->get('session')->has('state')
              && $this->container->get('session')->get('state') == self::STATE_CONFIRMATION)) {
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_product'));
        }

        $form = $this->createFormBuilder($this->container->get('session')->get('drinkOrder'))->getForm();
        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($this->container->get('session')->get('drinkOrder'));
            $em->flush();
            $this->container->get('session')->remove('state');
            $this->container->get('session')->setFlash('state', self::STATE_SUCCESS);
            $this->container->get('session')->remove('drinkOrder');
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_success'));
        } else {
            return $this->render('OscDrinkOrderBundle:DrinkOrder:confirmation.html.twig', array(
                'form' => $form->createView(),
                'drinkOrder' => $this->container->get('session')->get('drinkOrder')
            ));
        }
    }

    public function successAction()
    {
        if (!($this->container->get('session')->hasFlash('state')
              && $this->container->get('session')->getFlash('state') == self::STATE_SUCCESS)) {
            return $this->redirect($this->generateUrl('OscDrinkOrderBundle_product'));
        }

        return $this->render('OscDrinkOrderBundle:DrinkOrder:success.html.twig');
    }
}
