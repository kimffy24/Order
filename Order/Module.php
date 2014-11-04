<?php

namespace Order;

use Zend\ModuleManager\ModuleManager;
use Order\Service\PersistOrder;
use Order\Service\PersistMultiOrder;

class Module {
	public function init(ModuleManager $moduleManager) {
		/*$sharedEvents = $moduleManager->getEventManager ()->getSharedManager ();
		$sharedEvents->attach ( __NAMESPACE__, 'dispatch', function ($e) {
			$controller = $e->getTarget ();
			$controller->layout ( 'layout/layoutWxb' );
		}, 100 );*/
	}
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
						) 
				) 
		);
	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	public function getServiceConfig() {
		return array (
				'factories' => array (
						'Order\Service\PersistOrder' => function($sm) {
							return new PersistOrder($sm->get('OrderDbAdapter'));
						},
						'Order\Service\PersistMultiOrder' => function($sm) {
							return new PersistMultiOrder($sm->get('OrderDbAdapter'));
						}
				)
		);
	}
}
