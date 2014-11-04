<?php

namespace Order\Filter;

use Zend\Validator\Regex;

class CreateFilter {
	static public function doCreateFilter($args) {
		$vg = CreateFilter::$validGroup;
		
		unset($vg['id']);
		unset($vg['logistics_single']);
		
		foreach ($vg as $k => $v){
			if(isset($args[$k]) and !empty($args[$k])){
				$chain = CreateFilter::validatorExecute($args[$k], $v);
				if(!$chain)
					return false;
			}
		}
		return true;
	}
	static public function doQueryFilter($args) {
		$vg = array();
		$vg['id'] = CreateFilter::$validGroup['id'];
		$vg['type'] = CreateFilter::$validGroup['type'];

		foreach ($vg as $k => $v){
			if(isset($args[$k]) and !empty($args[$k])){
				$chain = CreateFilter::validatorExecute($args[$k], $v);
				if(!$chain)
					return false;
			}
		}
		return true;
	}
	
	static private function validatorExecute($value, $rule = null) {
		return (new Regex ( array (
				'pattern' => $rule 
		) ))->isValid ( $value );
	}
	static $validGroup = array (
			'id' => '/\\d{1,10}$/',
			'cost' => '/\\d{1,10}(\\.\\d{1,2})?$/',
			'type' => '/[0-2]/',
			'uid' => '/\\d{1,10}$/',
			'logistics' => '/[0-1]/',
			'gkey' => '/\\d{1,10}$/',
			'mkey' => '/\\d{1,10}$/',
			'amount' => '/\\d{1,10}$/',
			'logistics_single' => '/[a-zA-Z0-9]+/'
	);
}