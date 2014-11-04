<?php

namespace Order\Model;

use Order\Aggregate\AggregateAwareInterface;
use Order\Aggregate\AggregateInterface;

class DetailModel implements AggregateAwareInterface {
	private $amount;
	private $spec;
	private $mkey;
	private $gkey;
	
	public function getArrayCopy() {
		return array (
				'amount' => $this->amount,
				'spec' => $this->spec,
				'mkey' => $this->mkey,
				'gkey' => $this->gkey 
		);
	}

	/**
	 * @return the $amount
	 */
	public function getAmount() {
		return $this->amount;
	}
	
	/**
	 * @return the $spec
	 */
	public function getSpec() {
		return $this->spec;
	}
	
	/**
	 * @return the $mkey
	 */
	public function getMkey() {
		return $this->mkey;
	}
	
	/**
	 * @return the $gkey
	 */
	public function getGkey() {
		return $this->gkey;
	}
	
	/**
	 * @param field_type $amount
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
	}
	
	/**
	 * @param field_type $spec
	 */
	public function setSpec($spec) {
		$this->spec = $spec;
	}
	
	/**
	 * @param field_type $mkey
	 */
	public function setMkey($mkey) {
		$this->mkey = $mkey;
	}
	
	/**
	 * @param field_type $gkey
	 */
	public function setGkey($gkey) {
		$this->gkey = $gkey;
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