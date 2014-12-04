<?php
namespace Order\Aggregate\PaymentOrder;

use Order\Aggregate\Utils\EasyProperties;
use Order\Aggregate\Utils\AggregateInterface;
use Order\Aggregate\BuyOrder\BuyOrder;

/**
 * 支付单
 * @author JiefzzLon
 *
 */
class PaymentOrder extends EasyProperties implements AggregateInterface
{
    private $id;
    public function __construct(){
        parent::__construct(array('type','total','payed', 'buy_order_list'));
        $this->setBuyOrderList(array());
    }
	/**
     * @see \Order\Aggregate\Utils\AggregateInterface::getId()
     */
    public function getId()
    {
        // TODO Auto-generated method stub
        return $this->id;
    }
    public function __call($method, $args){
        $analyze = $this->analyzeOperation($method);
        $op = $analyze['op'];
        $target = $analyze['target'];
        if($op=='get' or $op=='set')
            return parent::__call($method, $args);
        if($target == $this->getMapKey('buy_order_list')){
            switch($op){
                case 'add':
                    if($args[0] instanceof BuyOrder){
                        $obj = call_user_func_array(array($this, 'get'.$target), array());
                        $new_params = array(spl_object_hash($args[0])=>$args[0]);
                        call_user_func_array(array($this, 'set'.$target), array(array_merge($obj,$new_params)));
                    }
                    break;
                case 'del':
                    if($args[0] instanceof BuyOrder){
                        $obj = call_user_func_array(array($this, 'get'.$target), array());
                        $delete_key = spl_object_hash($args[0]);
                        if(key_exists($delete_key, $obj))
                            unset($obj[$delete_key]);
                        call_user_func_array(array($this, 'set'.$target), array(array_merge($obj,$new_params)));
                    }
                    break;
                default:
                    ;
            }
            return;
        }
    }
    public function getParamsCopy(){
        $result = parent::getParamsCopy();
        $checkKey = 'buy_order_list';
        if(count($result[$checkKey]))
            foreach($result[$checkKey] as $k => $v)
                $result[$checkKey][$k] = ($v instanceof EasyProperties)?$v->getParamsCopy():$v;
        return $result;
    }
}