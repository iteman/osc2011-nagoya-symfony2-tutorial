<?php
namespace Osc\Bundle\DrinkOrderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductDrinkOrderType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('product_id', 'choice', array( 'choices' => array('1' => 'BlueBull 128個入ケース', '2' => 'GreenBull 128個入ケース')));
        $builder->add('quantity', 'text');
    }

    public function getName()
    {
        return 'product_drink_order';
    }
}
