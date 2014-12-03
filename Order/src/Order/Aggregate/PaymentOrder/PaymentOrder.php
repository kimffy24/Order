<?php
namespace Order\Aggregate\PaymentOrder;

use Order\Aggregate\Utils\EasyProperties;
use Order\Aggregate\Utils\AggregateInterface;

/**
 * 支付单
 * @author JiefzzLon
 *
 */
class PaymentOrder extends EasyProperties implements AggregateInterface
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