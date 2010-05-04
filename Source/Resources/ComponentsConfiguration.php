<?php

/**
 * Definition of default service implementations.
 *
 * @package    BachelorThesis
 * @subpackage Resources
 */
return array(
	'constants'  => array(

	),
	'components' => array(

		// Events
		'event_emitter_service' => array(
			'class' => 'LazyEventEmitter',
		),

		// Logger
		'logger_handler_service' => array(
			'class' => 'ArrayLogMessageHandler'
		),

		'logger_service' => array(
			'class' => 'Logger',
			'constructor' => array(
				array('component', 'logger_handler_service')
			)
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
			'class' => 'RequestBasePathStrategy',
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

		'response_presenter_service' => array(
			'class' => 'ResponsePresenter',
			'scope' => 'transient',
		),

		// Storage
		'storage_service' => array(
			'class' => 'SessionStorage',
		),
	)
);
