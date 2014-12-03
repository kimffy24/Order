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
        $this->keys=array('goods','seller','buyer','time','total');
        $this->params['goods'] = new Goods;
        $this->params['seller'] = null;
        $this->params['buyer'] = null;
        $this->params['time'] = null;
        $this->params['total'] = null;
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