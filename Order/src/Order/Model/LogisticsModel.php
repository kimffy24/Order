<?php

namespace Order\Model;

use Order\Aggregate\AggregateAwareInterface;
use Order\Aggregate\AggregateInterface;

class LogisticsModel implements AggregateAwareInterface {
	private $address;
	private $provider;
	private $logistics_single;
	
	/**
	 * 生成键值对数组，用于持久化
	 * @return multitype:field_type 
	 * @author JiefzzLon
	 */
	public function getArrayCopy() {
		return array (
				'address' => $this->address,
				'provider' => $this->provider,
				'logistics_single' => $this->logistics_single
		);
	}
	
	/**
	 * @return the $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @return the $provider
	 */
	public function getProvider() {
		return $this->provider;
	}

	/**
	 * @return the $logistics_single
	 */
	public function getLogistics_single() {
		return $this->logistics_single;
	}

	/**
	 * @param field_type $address
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * @param field_type $provider
	 */
	public function setProvider($provider) {
		$this->provider = $provider;
	}

	/**
	 * @param field_type $logistics_single
	 */
	public function setLogistics_single($logistics_single) {
		$this->logistics_single = $logistics_single;
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