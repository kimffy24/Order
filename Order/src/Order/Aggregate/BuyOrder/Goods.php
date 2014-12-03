<?php
namespace Order\Aggregate\BuyOrder;

use Order\Aggregate\Utils\EasyProperties;

class Goods extends EasyProperties
{
    public function __construct(){
        $this->keys = array('name','jingle','spec','amount','unit_price','snapshot');
        $this->params['name']=null;
        $this->params['jingle']=null;
        $this->params['spec']=null;
        $this->params['amount']=null;
        $this->params['unit_price']=null;
        $this->params['snapshot']=null;
    }
}