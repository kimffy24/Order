<?php

namespace Order\Service;

use Zend\Stdlib\Hydrator\ArraySerializable;
use Order\Aggregate\MultiOrder;
use Order\Aggregate\OrderFactory;

class PersistMultiOrder extends PersistOrder {
	public function persist(MultiOrder $mo){
		$this->persistParent($mo);
		if(!count($mo->getMulti()->getToDb()))
			return true;
		$po = new PersistOrder($this->getAdapter());
		foreach($mo->getMulti()->getChildren() as $value)
			$po->persist($value);
		
	}
	public function general($id, MultiOrder $order){
		$sqlString = "select * from main left outer join logistics on logistics.id=main.id where main.id=?";
		$result = current ( $this->getAdapter()->query ( $sqlString, array (
				$id 
		) )->toArray () );
		if (! $result)
			return false;
		
		$order->setKeysFromCollection($result);

		$sqlString = "select * from multi where multi.id=?";
		$result = $this->getAdapter()->query ( $sqlString, array (
				$id
		) )->toArray ();
		if(!count($result))
			return true;
		$po = new PersistOrder($this->getAdapter());
		foreach ($result as $value){
			$childOrder = OrderFactory::getInstance($value['cid'], $po);
			$order->getMulti()->addChild($childOrder);
		}
		return true;
	}
	
	private function persistParent(MultiOrder $order){
		$hydrator = new ArraySerializable ();

		try {
			if ($order->getId ()) {
				$this->getMainTableGateway ()->update ( $hydrator->extract ( $order->getMain () ), array (
						'id' => $order->getId ()
				) );
				if($order->getLogistics())
					$this->getLogisticsTableGateway ()->update ( $hydrator->extract ( $order->getLogistics () ), array (
						'id' => $order->getId ()
					) );
			} else {
				$this->getMainTableGateway ()->insert ( $hydrator->extract ( $order->getMain () ) );
				$orderId = $this->getMainTableGateway ()->getAdapter ()->getDriver ()->getConnection ()->getLastGeneratedValue ();
				$order->setId ( $orderId );
				if($order->getLogistics())
					$this->getLogisticsTableGateway ()->insert ( array_merge ( $hydrator->extract ( $order->getLogistics () ), array (
							'id' => $orderId 
					) ) );
			}
			if($order->getMulti()){
				$multi = $order->getMulti()->getToDb();
				$nowChildren = $this->getMultiTableGateway ()->select(array(id))->toArray();
				$nowChild = array();
				foreach($nowChildren as $value){
					$nowChild[intval($value['cid'])] = $order->getId ();
				}

				$arr_add = array_diff_assoc($multi,$nowChild);
				$arr_del = array_diff_assoc($nowChild,$multi);
				if(count($arr_add))
					foreach($arr_add as $key => $value)
						$this->getMultiTableGateway()->insert(array('id'=>$value, 'cid'=>$key));
				if(count($arr_del))
					foreach($arr_del as $key => $value)
						$this->getMultiTableGateway()->delete(array('id'=>$value, 'cid'=>$key));
			}
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}