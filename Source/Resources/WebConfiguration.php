<?php

/**
 * Extended services with application functionality.
 *
 * @package    BachelorThesis
 * @subpackage Resources
 */
return array(
	'constants'  => array(

	),
	'components' => array(

		// paths
		'path_collection_service' => array(
			'class' => 'PathCollection'
		),

		// runner
		'controller_runner_service' => array(
			'class' => 'ControllerRunner'
		),

		// route load listener
		'route_load_listener' => array(
			'class' => 'RouteLoadListener',
			'constructor' => array(
				array('component', 'router_service'),
			),
			'notes' => array(
				'listener' => array(
					array('route.load', 'handle')
				),
			)
		),

		// controller loader with listener
		'controller_loader_service' => array(
			'class' => 'ControllerLoader',
			'constructor' => array(
				array('component', 'path_collection_service'),
				array('component', 'container_service'),
				array('component', 'ControllerNameStrategy')
			),
		),

		'controller_load_listener' => array(
			'class' => 'ControllerLoadListener',
			'constructor' => array(
				array('component', 'controller_loader_service'),
			),
			'notes' => array(
				'listener' => array(
					array('controller.load', 'handle'),
				)
			)
		),

		'action_name_strategy_service' => array(
			'class' => 'ActionNameStrategy'
		),

		// controller action invoker with listener
		'controller_action_invoker_service' => array(
			'class' => 'ControllerActionInvoker',
			'constructor' => array(
				array('component', 'reflection_cache_service'),
				array('component', 'action_name_strategy_service')
			),
		),

		'controller_invoke_listener' => array(
			'class' => 'ControllerInvokeListener',
			'constructor' => array(
				array('component', 'controller_action_invoker_service')
			),
			'notes' => array(
				'listener' => array(
					array('controller.invoke', 'handle')
				)
			)
		),

		// command action invoker with listener
		'command_action_invoker_service' => array(
			'class' => 'CommandActionInvoker',
			'constructor' => array(
				array('component', 'path_collection_service'),
				array('component', 'container_service'),
				array('component', 'reflection_cache_service'),
				array('component', 'action_name_strategy_service'),
				array('component', 'CommandNameStrategy'),
			)
		),

		'command_action_invoker_listener' => array(
			'class' => 'ControllerInvokeListener',
			'constructor' => array(
				array('component', 'command_action_invoker_service'),
			),
			'notes' => array(
				'listener' => array(
					array('controller.invoke', 'handle')
				)
			)
		),

		// view render listener
		'controller_view_listener' => array(
			'class' => 'BasicViewLoadListener',
			'notes' => array(
				'listener' => array(
					array('controller.view', 'handle'),
				)
			),
		),

		// user
		'user_service' => array(
			'class' => 'User',
			'constructor' => array(
				array('component', 'storage_service'),
				array('component', 'event_emitter_service')
			)
		),
	)
);
