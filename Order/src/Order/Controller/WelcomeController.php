<?php

namespace Order\Controller;

use Zend\View\Model\JsonModel;
use Order\Aggregate\OrderFactory;
use Order\Filter\CreateFilter;
use Order\Aggregate\MultiOrder;

class WelcomeController extends BaseController {
	public function welcomeAction(){
		$bar = 'merchant_key';
		$res = array('msg' => ucfirst(strtolower($bar)));
		return new JsonModel($res);
	}
	public function testPsersistOrderInsertAction(){
		$po = $this->getServiceLocator()->get('Order\Service\PersistOrder');
		$order = OrderFactory::getInstance();
		$order->doCommand('cost', array(1258));
		$order->doCommand('launch', array('default store'.time()));
		$order->doCommand('uid', array('kimffy'));
		
		$order->doCommand('mkey', array('eterchen'));
		$order->doCommand('gkey', array('EZ00001'));
		$order->doCommand('spec', array(json_encode(array('颜色'=>'红色'))));
		$order->doCommand('amount', array('10'));

		$order->getMain()->useLogistics();
		$order->doCommand('address', array('广州市天河区黄埔大道'));
		$order->doCommand('provider', array('顺丰快递'));
		$order->doCommand('logistics_single', array('GZ000000000125325555'));
		
		$result = $po->persist($order);
		return new JsonModel(['result'=>$result]);
	}
	public function testPsersistOrderGetAction(){
		$po = $this->getServiceLocator()->get('Order\Service\PersistOrder');
		$order = OrderFactory::getInstance(5, $po);
		var_dump($order);die();
	}
	public function testPsersistOrderRefreshAction() {
		
	}
	public function testPsersistOrderFilterAction() {
		$request = $this->getRequest();
		var_dump(CreateFilter::doCreateFilter($request->getPost()));die();
	}
	public function testQueryMultiAction(){
		$pmo = $this->getServiceLocator()->get('Order\Service\PersistMultiOrder');
		$order = new MultiOrder();
		$pmo->general(16, $order);
		echo json_encode($order->toArray());die();
	}
}