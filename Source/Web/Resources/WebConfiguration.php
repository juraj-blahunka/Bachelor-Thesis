<?php

return array(
	'constants'  => array(

	),
	'components' => array(

		'event_emitter_service' => array(
			'class' => 'LazyEventEmitter'
		),

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

		'controller_runner_service' => array(
			'class' => 'ControllerRunner'
		),

	)
);
