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

		'RouterFactory'       => array(),
		'RouteMatcher'        => array(),
		'RoutingRuleCompiler' => array(),
		'UrlCreator'          => array(),

	)
);
