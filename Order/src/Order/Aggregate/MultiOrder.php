<?php

namespace Order\Aggregate;

use Order\Model\MultiModel;
use Order\Service\PersistOrder;

class MultiOrder extends BaseOrder {
	public function __construct($id=null){
		parent::__construct($id);
		$this->setDetail(null);
		$this->setMulti(new MultiModel());
		$this->getMulti()->setAggregate($this);
	}
	public function toArray(){
		$snapshot = parent::toArray();
		foreach($this->getMulti()->getChildrenOrders() as $child)
			$snapshot['children'][]=$child->toArray();
		return $snapshot;
	}
	public function general2(PersistOrder $po){
		if(!$this->getId())
			return;
		if(!$po->general($this->getId(), $this))
			throw new AggregateBuildException();
	}
	public function addChild(Order $order){
		if(!$this->getMulti()) $this->setMulti(new MultiModel());
		$this->getMulti()->addChild($order);
	}
}