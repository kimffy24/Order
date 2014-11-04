<?php

namespace Order\Model;

use Order\Aggregate\AggregateAwareInterface;
use Order\Aggregate\AggregateInterface;
use Order\Aggregate\Order;

class MultiModel implements AggregateAwareInterface {
	
	private $children = array();
	private $chs = array();
	
	public function addChild(Order $mo){
		$this->chs[intval($mo->getId())] = $this->getAggregate()->getId();
		$this->children[intval($mo->getId())] = $mo;
		$mo->setParent($this->getAggregate());
	}
	public function getToDbPair(){
		return $this->chs;
	}
	public function getChildrenOrders(){
		return $this->children;
	}
	
	private $orderAggregate;
	/* (non-PHPdoc)
	 * @see \Order\Aggregate\AggregateAwareInterface::setAggregate()
	 */
	public function setAggregate(AggregateInterface $a) {
		// TODO Auto-generated method stub
		$this->orderAggregate = $a;
	}

	/* (non-PHPdoc)
	 * @see \Order\Aggregate\AggregateAwareInterface::getAggregate()
	 */
	public function getAggregate() {
		// TODO Auto-generated method stub
		return $this->orderAggregate;
	}

}