<?php

namespace Order\Controller;

use Order\Aggregate\BuyOrder\BurOrder;

class WelcomeController extends BaseController {
	public function welcomeAction(){
		$bar = 'merchant_key';
		$res = array(
		    'msg' => ucfirst(strtolower($bar)),
		    'class' => new BurOrder()
		);
		return $res;
	}
}