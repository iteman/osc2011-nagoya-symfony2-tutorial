<?php
namespace Osc\Bundle\DrinkOrderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddressDrinkOrderType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('address', 'text');
        $builder->add('phone', 'text');
    }

    public function getName()
    {
        return 'address_drink_order';
    }
}
