<?php
namespace Order\Aggregate\BuyOrder;

use Order\Aggregate\Utils\EasyProperties;

class Goods extends EasyProperties
{
    public function __construct(){
        parent::__construct(array('name','jingle','spec','amount','unit_price','snapshot'));
    }
}