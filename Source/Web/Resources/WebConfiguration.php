<?php

return array(
	'constants'  => array(

	),
	'components' => array(

		'EventEmitter' => array(
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
		)

	)
);
