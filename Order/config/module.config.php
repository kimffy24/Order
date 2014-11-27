<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'Order\Controller\Welcome' => 'Order\Controller\WelcomeController',
						'Order\Controller\Unified' => 'Order\Controller\UnifiedController'
				) 
		),
		'view_manager' => array (
				'strategies' => array (
						'ViewJsonStrategy' 
				) 
		),
		'db_order' => array (
				'driver' => 'Pdo',
				'dsn' => 'mysql:dbname=order2;host=10.8.0.10',
				'username' => 'root',
				'password' => 'hxhsql',
				'driver_options' => array (
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'' 
				) 
		),
		'service_manager' => array (
				'factories' => array (
						'OrderDbAdapter' => function ($sm) {
							$config = $sm->get ( 'Config' );
							return new Zend\Db\Adapter\Adapter ( $config ['db_order'] );
						} 
				) 
		),
		'router' => array (
				'routes' => array (
						'order' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/order[/]',
										'defaults' => array (
												'__NAMESPACE__' => 'Order\Controller',
												'controller' => 'WelcomeController',
												'action' => 'welcome' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'order_controller' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '[:controller][/]',
														'constraints' => array (
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]+' 
														),
														'defaults' => array (
																'__NAMESPACE__' => 'Order\Controller',
																'controller' => 'WelcomeController',
																'action' => 'welcome' 
														) 
												),
												'may_terminate' => true,
												'child_routes' => array (
														'order_action' => array (
																'type' => 'Segment',
																'options' => array (
																		'route' => '[:action][/]',
																		'constraints' => array (
																				'action' => '[a-zA-Z0-9_-]+' 
																		),
																		'defaults' => array (
																				'action' => 'notFound' 
																		) 
																) 
														) 
												) 
										) 
								) 
						) 
				) 
		) 
);
