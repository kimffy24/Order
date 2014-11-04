<?php

namespace Order\Aggregate;

use Order\Service\PersistOrder;

class OrderFactory {
	static private $instances = array();
	static function getInstance($id=null, PersistOrder $persist=null){
		if($id==null)
			return new Order();
		if(isset(OrderFactory::$instances[$id]) and !empty(OrderFactory::$instances[$id]))
			return OrderFactory::$instances[$id];
		$ins = new Order();
		$ins->setId($id);
		if($ins->doCommand('general', $persist))
			OrderFactory::$instances[$id] = $ins;
		return $ins;
	}
	static function getMultiOrderInstance($id=null, PersistOrder $persist=null){
		if($id==null)
			return new MultiOrder();
		if(isset(OrderFactory::$instances[$id]) and !empty(OrderFactory::$instances[$id]))
			return OrderFactory::$instances[$id];
		$ins = new MultiOrder ();
		$ins->setId($id);
		if($ins->doCommand('general', $persist))
			OrderFactory::$instances[$id] = $ins;
		return $ins;
	}
}