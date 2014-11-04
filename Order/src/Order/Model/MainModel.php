<?php
namespace Order\Model;

use Order\Aggregate\AggregateAwareInterface;
use Order\Aggregate\AggregateInterface;

class MainModel implements AggregateAwareInterface {
	
	const CREATE=0;
	const ONPAY=1;
	const FINISH=2;
	const DISCARD=3;
	const ADULTS=4;
	const ADULTSFINISH=5;
	
	const SINGLEORDER=0;
	const MULTIORDER=1;
	const CHILDORDER=2;

	const UNUSELOGISTICS=0;
	const USELOGISTICS=1;
	
	private $cost;
	private $paystatus=self::CREATE;
	private $uid;
	private $launch;
	private $type=self::SINGLEORDER;
	private $logistics;
	private $parent;
	
	/**
	 * 更改订单状态为OnPay
	 * 
	 * @author JiefzzLon
	 */
	public function onpay(){
		$this->paystatus=self::ONPAY;
	}
	/**
	 * 更改订单状态为Finish
	 * 
	 * @author JiefzzLon
	 */
	public function finish(){
		$this->paystatus=self::FINISH;
	}
	/**
	 * 更改订单状态为Discard
	 * 
	 * @author JiefzzLon
	 */
	public function discard(){
		$this->paystatus=self::DISCARD;
	}
	/**
	 * 更改订单状态为Adults
	 * 
	 * @author JiefzzLon
	 */
	public function adults(){
		$this->paystatus=self::ADULTS;
	}
	/**
	 * 更改订单状态为AdultsFinish
	 * 
	 * @author JiefzzLon
	 */
	public function adultsfinish(){
		$this->paystatus=self::ADULTSFINISH;
	}
	
	/**
	 * 设置订单的物流标识
	 * 
	 * @author JiefzzLon
	 */
	public function useLogistics(){
		$this->setLogistics(self::USELOGISTICS);
	}
	/**
	 * 解除订单的物流标识
	 * 
	 * @author JiefzzLon
	 */
	public function unuseLogistics(){
		$this->setLogistics(self::UNUSELOGISTICS);
	}
	
	

	/**
	 * 生成键值对，用于持久化
	 * @return multitype:field_type string 
	 * @author JiefzzLon
	 */
	public function getArrayCopy() {
		return array (
				'cost' => $this->cost,
				'paystatus' => $this->paystatus,
				'uid' => $this->uid,
				'launch' => $this->launch,
				'type' => $this->type,
				'logistics' => $this->logistics
		);
	}
	

	/**
	 * @return the $logistics
	 */
	public function isUseLogistics() {
		return $this->logistics;
	}
	
	/**
	 * @return the $cost
	 */
	public function getCost() {
		return $this->cost;
	}

	/**
	 * @return the $uid
	 */
	public function getUid() {
		return $this->uid;
	}

	/**
	 * @return the $launch
	 */
	public function getLaunch() {
		return $this->launch;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}


	/**
	 * @param field_type $cost
	 */
	public function setCost($cost) {
		$this->cost = $cost;
	}

	/**
	 * @param field_type $uid
	 */
	public function setUid($uid) {
		$this->uid = $uid;
	}

	/**
	 * @param field_type $launch
	 */
	public function setLaunch($launch) {
		$this->launch = $launch;
	}

	/**
	 * @param field_type $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @param field_type $logistics
	 */
	public function setLogistics($logistics) {
		$this->logistics = $logistics;
	}

	/**
	 * @return the $parent
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param field_type $parent
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}
	
	/**
	 * @return the $paystatus
	 */
	public function getPaystatus() {
		return $this->paystatus;
	}

	private $orderAggregate;
	/**
	 * @see \Order\Aggregate\AggregateAwareInterface::setAggregate()
	 */
	public function setAggregate(AggregateInterface $a) {
		// TODO Auto-generated method stub
		$this->orderAggregate = $a;
	}
	
	/**
	 * @see \Order\Aggregate\AggregateAwareInterface::getAggregate()
	 */
	public function getAggregate() {
		// TODO Auto-generated method stub
		return $this->orderAggregate;
	}
}