<?php
namespace Order\Aggregate\Delivery;

use Order\Aggregate\Utils\EasyProperties;
use Order\Aggregate\Utils\AggregateInterface;

/**
 * 交付规格
 * @author JiefzzLon
 *
 */
class Delivery extends EasyProperties implements AggregateInterface
{
    private $id;
    
	/**
     * @see \Order\Aggregate\Utils\AggregateInterface::getId()
     */
    public function getId()
    {
        // TODO Auto-generated method stub
        return $this->id;
    }

}