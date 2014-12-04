<?php
namespace Order\Aggregate\BuyOrder;

use Order\Aggregate\Utils\AggregateInterface;
use Order\Aggregate\Utils\EasyProperties;
use Order\Aggregate\BuyOrder\Goods;

/**
 * 购物单
 * @author JiefzzLon
 *
 */
class BuyOrder extends EasyProperties implements AggregateInterface
{
    private $id;
    
    public function __construct(){
        parent::__construct(array('goods','seller','buyer','time','total'));
        $this->setGoods(new Goods());
    }
	/**
     * @see \Order\Aggregate\AggregateInterface::getId()
     * @author JiefzzLon
     * @desc 獲取聚合跟標識符
     */
    public function getId()
    {
        // TODO Auto-generated method stub
        return $this->id;
    }

}