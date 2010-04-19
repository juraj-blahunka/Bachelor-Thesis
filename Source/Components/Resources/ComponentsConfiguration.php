<?php

return array(
	'constants'  => array(

	),
	'components' => array(

		// Events
		'EventEmitter' => array(),

		// Cache
		'ReflectionCache' => array(
			'constructor' => array(
				array('component', 'ClassReflectionCache'),
				array('component', 'MethodReflectionCache'),
			)
		),

		// Router
		'base_path_strategy_service' => array(
			'class' => 'RequestBaseUrlStrategy',
		),
		'RouterFactory'       => array(),
		'RouteMatcher'        => array(),
		'RoutingRuleCompiler' => array(),
		'UrlCreator'          => array(),

		'router_service' => array(
			'class' => 'RouterManager',
		),
		
		// Http
		'request_service' => array(
			'class' => 'Request',
		),
		'response_service' => array(
			'class' => 'Response',
			'scope' => 'transient',
		),
	)
);
