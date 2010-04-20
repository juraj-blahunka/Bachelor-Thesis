<?php

return array(
	'constants'  => array(

	),
	'components' => array(

		// events
		'event_emitter_service' => array(
			'class' => 'LazyEventEmitter'
		),

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

		// controller action invoker with listener
		'controller_action_invoker_service' => array(
			'class' => 'ControllerActionInvoker',
			'constructor' => array(
				array('component', 'reflection_cache_service'),
				array('component', 'ActionNameStrategy')
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
		)
	)
);
