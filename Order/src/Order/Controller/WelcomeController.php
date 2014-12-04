<?php

namespace Order\Controller;

use Order\Aggregate\BuyOrder\BuyOrder;
use Order\Aggregate\PaymentOrder\PaymentOrder;

class WelcomeController extends BaseController {
	public function welcomeAction(){
		$bar = 'merchant_key';
		$buyOrder1 = new BuyOrder();
		$buyOrder1->getGoods()->setName('Kimffy');
		$buyOrder1->getGoods()->setUnitPrice('15.6');
		$buyOrder1->getGoods()->setAmount('2');
		$buyOrder2 = new BuyOrder();
		$buyOrder2->getGoods()->setName('Jiefzz');
		$buyOrder2->getGoods()->setUnitPrice('799');
		$buyOrder2->getGoods()->setAmount('128');
		$paymentOrder = new PaymentOrder;
		$paymentOrder->addBuyOrderList($buyOrder1);
		$paymentOrder->addBuyOrderList($buyOrder2);
		return array('$paymentOrder'=>$paymentOrder->getParamsCopy());
	}
}