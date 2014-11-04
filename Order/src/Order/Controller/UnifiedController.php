<?php

namespace Order\Controller;

use Order\Filter\CreateFilter;
use Order\Aggregate\OrderFactory;
use Order\Aggregate\Order;
use Order\Aggregate\MultiOrder;


class UnifiedController extends BaseController {
	public function createAction() {
		$request = $this->getRequest ();
		$args = $request->getPost ()->toArray();
		if (! CreateFilter::doCreateFilter ( $args ))
			die ();
		
		$po = $this->getServiceLocator ()->get ( 'Order\Service\PersistOrder' );
		$order = OrderFactory::getInstance ();
		foreach ($args as $k => $v)
			$order->doCommand($k, array($v));
		$po->persist($order);
		return $this->createJsonView(array('orderId'=>$order->getId()));
	}
	public function queryAction(){
		$request = $this->getRequest ();
		$args = $request->getPost ()->toArray();
		if (! CreateFilter::doQueryFilter($args))
			die ();
		
		$po = $this->getServiceLocator ()->get ( 'Order\Service\PersistOrder' );
		$order = OrderFactory::getInstance ($args['id'], $po);
		return $this->createJsonView(array('order' => $order->toArray()));
	}
	public function queryPaymentAction(){
		$request = $this->getRequest ();
		$args = $request->getPost ()->toArray();
		if (! CreateFilter::doQueryFilter($args))
			die ();
		
		$po = $this->getServiceLocator ()->get ( 'Order\Service\PersistOrder' );
		$order = OrderFactory::getInstance ($args['id'], $po);
		return $this->createJsonView(array('paystatus' => $order->getMain()->getPaystatus()));
	}
	public function updateAction(){
		
	}
	public function createMultiAction() {
		
	}
	public function queryMultiAction(){
		$request = $this->getRequest ();
		$args = $request->getPost ()->toArray();
		if (! CreateFilter::doQueryFilter($args))
			die ();
		
		$pmo = $this->getServiceLocator()->get('Order\Service\PersistMultiOrder');
		$order = OrderFactory::getMultiOrderInstance ($args['id'], $pmo);
		return $this->createJsonView(array('order' => $order->toArray()));
	}
	public function finishAction(){
		$request = $this->getRequest ();
		$args = $request->getPost ()->toArray();
		if (! CreateFilter::doQueryFilter($args))
			die ();

		$po = $this->getServiceLocator ()->get ( 'Order\Service\PersistOrder' );
		$order = OrderFactory::getInstance ($args['id'], $po);
		$order->doCommand(Order::FINISH);
		$result = $po->persist($order);
		return $this->createJsonView(array('result'=>$result));
	}
}