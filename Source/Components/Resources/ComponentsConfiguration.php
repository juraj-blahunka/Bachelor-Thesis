<?php

return array(
	'constants'  => array(

	),
	'components' => array(

		// Events
		'event_emitter_service' => array(
			'class' => 'EventEmitter',
		),

		// Cache
		'ClassReflectionCache', 'MethodReflectionCache',

		'reflection_cache_service' => array(
			'class' => 'ReflectionCache',
			'constructor' => array(
				array('component', 'ClassReflectionCache'),
				array('component', 'MethodReflectionCache'),
			)
		),

		// Router
		'RouterFactory', 'RouteMatcher', 'RoutingRuleCompiler', 'UrlCreator',

		'base_path_strategy_service' => array(
			'class' => 'RequestBaseUrlStrategy',
		),

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

		'renderable_response_service' => array(
			'class' => 'RenderableResponse',
			'scope' => 'transient',
		),
	)
);
