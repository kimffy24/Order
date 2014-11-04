<?php

namespace Order\Form;

use Zend\Form\Form;

class OrderForm extends Form {
	public function __construct($name = null) {
		// we want to ignore the name passed
		parent::__construct ( 'order' );
		
		//查询号
		$this->add ( array (
				'name' => 'id',
				'type' => 'Text' 
		) );
		
		//主表信息
		$this->add ( array (
				'name' => 'cost',
				'type' => 'Text' 
		) );
		$this->add ( array (
				'name' => 'type',
				'type' => 'Text' 
		) );
		$this->add ( array (
				'name' => 'launch',
				'type' => 'Text' 
		) );
		$this->add ( array (
				'name' => 'parent',
				'type' => 'Text' 
		) );
		$this->add ( array (
				'name' => 'uid',
				'type' => 'Text' 
		) );
		$this->add ( array (
				'name' => 'logistics',
				'type' => 'Text' 
		) );
		
		//外关联信息//规格数量
		$this->add ( array (
				'name' => 'gkey',
				'type' => 'Text' 
		) );
		$this->add ( array (
				'name' => 'mkey',
				'type' => 'Text' 
		) );
		$this->add ( array (
				'name' => 'spec',
				'type' => 'Text'
		) );
		$this->add ( array (
				'name' => 'amount',
				'type' => 'Text'
		) );
		
		//物流
		$this->add ( array (
				'name' => 'address',
				'type' => 'Text'
		) );
		$this->add ( array (
				'name' => 'provider',
				'type' => 'Text'
		) );
		$this->add ( array (
				'name' => 'logistics_single',
				'type' => 'Text'
		) );
		
	}
}