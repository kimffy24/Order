<?php

namespace Order\Controller;

use Order\Aggregate\BuyOrder\BurOrder;

class WelcomeController extends BaseController {
	public function welcomeAction(){
		$bar = 'merchant_key';
		$cls = new BurOrder();
		$res = array(
		    'msg' => ucfirst(strtolower($bar)),
		    'class' => $cls
		);
		$cls->getGoods()->setName('Kimffy');
		return $cls->getParamsCopy();
	}
}