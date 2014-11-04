<?php

namespace Order\Service;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ArraySerializable;
use Order\Aggregate\Order;

class PersistOrder {
	const MAINTABLE = 'main';
	const MULTITABLE = 'multi';
	const DETAILTABLE = 'detail';
	const LOGISTICSTABLE = 'logistics';
	private $dbAdapter = null;
	private $mainTableGateway = null;
	private $multiTableGateway = null;
	private $detailTableGateway = null;
	private $logisticsTableGateway = null;
	public function __construct(Adapter $dbAdapter) {
		$this->dbAdapter = $dbAdapter;
	}
	public function persist(Order $order) {
		$hydrator = new ArraySerializable ();
		try {
			if ($order->getId ()) {
				$this->getMainTableGateway ()->update ( $hydrator->extract ( $order->getMain () ), array (
						'id' => $order->getId () 
				) );
				if($order->getDetail())
					$this->getDetailTableGateway ()->update ( $hydrator->extract ( $order->getDetail () ), array (
							'id' => $order->getId () 
					) );
				else $this->getDetailTableGateway ()->delete(array (
							'id' => $order->getId () 
					) );
				if($order->getLogistics())
					$this->getLogisticsTableGateway ()->update ( $hydrator->extract ( $order->getLogistics () ), array (
							'id' => $order->getId () 
					) );
				else $this->getLogisticsTableGateway ()->delete(array (
							'id' => $order->getId () 
					) );
			} else {
				$this->getMainTableGateway ()->insert ( $hydrator->extract ( $order->getMain () ) );
				$orderId = $this->getMainTableGateway ()->getAdapter ()->getDriver ()->getConnection ()->getLastGeneratedValue ();
				$order->setId ( $orderId );
				if($order->getDetail())
					$this->getDetailTableGateway ()->insert ( array_merge ( $hydrator->extract ( $order->getDetail () ), array (
							'id' => $orderId 
					) ) );
				if($order->getLogistics())
					$this->getLogisticsTableGateway ()->insert ( array_merge ( $hydrator->extract ( $order->getLogistics () ), array (
							'id' => $orderId 
					) ) );
			}
		} catch ( \Exception $e ) {
			throw $e;
			return false;
		}
		return $order->getId ();
	}
	public function general($id, Order $order) {
		$sqlString = "select * from main left outer join multi on main.id=multi.id left outer join detail on detail.id=main.id left outer join logistics on logistics.id=main.id where main.id=?";
		$result = current ( $this->dbAdapter->query ( $sqlString, array (
				$id 
		) )->toArray () );
		if (! $result)
			return false;
		$order->setKeysFromCollection($result);
		return true;
	}

	
	/**
	 *
	 * @return \Zend\Db\TableGateway\TableGateway
	 */
	protected  function getMainTableGateway() {
		return ($this->mainTableGateway) ? $this->mainTableGateway : new TableGateway ( PersistOrder::MAINTABLE, $this->dbAdapter );
	}
	/**
	 * @return \Zend\Db\TableGateway\TableGateway
	 */
	protected function getMultiTableGateway() {
		return ($this->multiTableGateway) ? $this->multiTableGateway : new TableGateway ( PersistOrder::MULTITABLE, $this->dbAdapter );
	}
	/**
	 * @return \Zend\Db\TableGateway\TableGateway
	 */
	protected function getDetailTableGateway() {
		return ($this->detailTableGateway) ? $this->detailTableGateway : new TableGateway ( PersistOrder::DETAILTABLE, $this->dbAdapter );
	}
	/**
	 * @return \Zend\Db\TableGateway\TableGateway
	 */
	protected function getLogisticsTableGateway() {
		return ($this->logisticsTableGateway) ? $this->logisticsTableGateway : new TableGateway ( PersistOrder::LOGISTICSTABLE, $this->dbAdapter );
	}
	protected function getAdapter(){
		return $this->dbAdapter;
	}
}