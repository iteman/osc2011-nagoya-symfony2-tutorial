<?php

namespace Osc\Bundle\DrinkOrderBundle\Entity;

/**
 * Osc\Bundle\DrinkOrderBundle\Entity\DrinkOrder
 */
class DrinkOrder
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $product_id
     */
    private $product_id;

    /**
     * @var integer $quantity
     */
    private $quantity;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set product_id
     *
     * @param integer $productId
     */
    public function setProductId($productId)
    {
        $this->product_id = $productId;
    }

    /**
     * Get product_id
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
