<?php
namespace Order\Aggregate;

use Order\Model\MainModel;
use Order\Model\LogisticsModel;

abstract class BaseOrder implements AggregateInterface {

	const GENERAL = 'general';
	
	const ONPAY = 'onpay';
	const FINISH = 'finish';
	const DISCARD = 'discard';
	const ADULTS = 'adults';
	const ADULTSFINISH = 'adultsfinish';
	
	const GET = 'get';
	const SET = 'set';
	
	private $id;
	private $main;
	private $detail;
	private $multi;
	private $logistics;
	
	public function __construct($id = null) {
		$mainModel = new MainModel ();
		$this->setMain($mainModel);
		if($id)
			$this->setId($id);
	}
	
	public function doCommand($cmd, $params = null) {
		
		$collection=array();
		if($this->getMain ()) $collection[]=$this->getMain ();
		if($this->getDetail ()) $collection[]=$this->getDetail ();
		if($this->getLogistics ()) $collection[]=$this->getLogistics ();
	
		switch ($cmd) {
			case self::GENERAL :
				return $this->general2 ( $params );
			case self::ONPAY :
				return $this->getMain()->onpay();
			case self::FINISH :
				return $this->getMain ()->finish ();
			case self::DISCARD :
				return $this->getMain ()->discard ();
			case self::ADULTS :
				return $this->getMain ()->adults ();
			case self::ADULTSFINISH :
				return $this->getMain ()->adultsfinish ();
			default :
				$method = 'set' . ucfirst ( strtolower ( $cmd ) );
				foreach($collection as $unit)
					if (method_exists ( $unit, $method )) {
						call_user_func_array ( array (
						$unit,
						$method
						), $params );
					}
		}
	}


	public function useLogistics(){
		$this->getMain()->useLogistics();
		$this->setLogistics(new LogisticsModel());
	}
	public function setAddress($address){
		if(!$this->getMain()->isUseLogistics())
			return;
		if(!$this->getLogistics()) $this->setLogistics(new LogisticsModel());
		$this->getLogistics()->setAddress($address);
	}
	public function unuseLogistics(){
		$this->getMain()->unuseLogistics();
		$this->setLogistics(null);
	}

	/**
	 * 序列化
	 * @Orverride
	 * @see \Order\Aggregate\AggregateInterface::toArray()
	 */
	public function toArray() {
		$snapshot = array ();
		$snapshot ['id'] = $this->getId ();
		$snapshot ['main'] = $this->getMain ()->getArrayCopy ();
		if($this->getDetail())
			$snapshot ['detail'] = $this->getDetail ()->getArrayCopy ();
		if($this->getLogistics())
			$snapshot ['logistics'] = $this->getLogistics ()->getArrayCopy ();
		return $snapshot;
	}
	/**
	 * 從數據庫集合中構造
	 * 非模型方法
	 * @param unknown $collection
	 * @author JiefzzLon
	 */
	public function setKeysFromCollection($result){
		// 龌龊实现
		$this->getMain ()->setCost ( $result ['cost'] );
		switch ($result ['paystatus']) {
			case MainModel::CREATE :
				break;
			case MainModel::ONPAY :
				$this->getMain ()->onpay ();
				break;
			case MainModel::FINISH :
				$this->getMain ()->finish ();
				break;
			case MainModel::DISCARD :
				$this->getMain ()->discard ();
				break;
			case MainModel::ADULTS :
				$this->getMain ()->adults ();
				break;
			case MainModel::ADULTSFINISH :
				$this->getMain ()->adultsfinish();
				break;
		}
		$this->getMain ()->setLaunch ( $result ['launch'] );
		$this->getMain ()->setUid ( $result ['uid'] );
	
		$this->getMain ()->setType ( $result ['type'] );
		switch( $result ['type'] ){
			case MainModel::MULTIORDER:
				$this->setDetail(null);
				break;
			case MainModel::CHILDORDER:;
			if(!empty($result ['parent']))
				$this->getMain ()->setParent ( $result ['parent'] );
			case MainModel::SINGLEORDER:
				$this->setMulti(null);
				break;
			default:
				throw new AggregateBuildException();
		}
		$this->getMain()->setLogistics( $result ['logistics'] );
		if($result ['logistics']==MainModel::UNUSELOGISTICS)
			$this->setLogistics(null);
		else if(!$this->getLogistics())
			$this->setLogistics(new LogisticsModel());
	
		if($this->getDetail()){
			$this->getDetail ()->setSpec ( $result ['spec'] );
			$this->getDetail ()->setAmount ( $result ['amount'] );
			$this->getDetail ()->setGkey( $result ['gkey'] );
			$this->getDetail ()->setMkey($result ['mkey']);
		}
	
		if($this->getMain ()->isUseLogistics()){
			$this->getLogistics ()->setAddress ( $result ['address'] );
			$this->getLogistics ()->setProvider ( $result ['provider'] );
			$this->getLogistics ()->setLogistics_single ( $result ['logistics_single'] );
		}
	}
	
	/**
	 * 獲取聚合對象DetailModel
	 * @return \Order\Model\DetailModel
	 * @author JiefzzLon
	 */
	public function getDetail() {
		return $this->detail;
	}
	/**
	 * 獲取聚合對象MainModel
	 * @return \Order\Model\MainModel
	 * @author JiefzzLon
	 */
	public function getMain() {
		return $this->main;
	}
	/**
	 * 獲取聚合對象LogisticsModel
	 * @return \Order\Model\LogisticsModel
	 * @author JiefzzLon
	 */
	public function getLogistics() {
		return $this->logistics;
	}
	/**
	 * 獲取聚合對象MultiModel
	 * @return \Order\Model\MultiModel
	 * @author JiefzzLon
	 */
	public function getMulti(){
		return $this->multi;
	}
	public function getId() {
		return $this->id ? $this->id : 0;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @param \Order\Model\MainModel $main
	 */
	protected function setMain($main) {
		$this->main = $main;
		$this->main->setAggregate($this);
	}

	/**
	 * @param \Order\Model\DetailModel $detail
	 */
	protected function setDetail($detail) {
		$this->detail = $detail;
		if($detail)
			$this->detail->setAggregate($this);
	}

	/**
	 * @param \Order\Model\MultiModel> $multi
	 */
	protected function setMulti($multi) {
		$this->multi = $multi;
		if($multi)
			$this->multi->setAggregate($this);
	}

	/**
	 * @param\Order\Model\LogisticsModel $logistics
	 */
	protected function setLogistics($logistics) {
		$this->logistics = $logistics;
		if($logistics)
			$this->logistics->setAggregate($this);
	}
}