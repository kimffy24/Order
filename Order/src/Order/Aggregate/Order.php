<?php
namespace Order\Aggregate;

use Order\Service\PersistOrder;
use Order\Model\MainModel;
use Order\Model\DetailModel;
use Order\Model\LogisticsModel;

class Order extends BaseOrder {
	public function __construct($id=null){
		parent::__construct($id);
		$this->setDetail(new DetailModel());
		$this->setLogistics(new LogisticsModel());
	}
	public function setParent(BaseOrder $bo){
		if( $bo->getMain()->getType() != MainModel::MULTIORDER )
			throw new AggregateBuildException();
		$this->getMain()->setType(MainModel::CHILDORDER);
		if($bo->getId())
			$this->getMain()->setParent($bo->getId());
	}
	public function general2(PersistOrder $po){
		if(!$this->getId())
			return;
		if(!$po->general($this->getId(), $this))
			throw new AggregateBuildException();
	}
}