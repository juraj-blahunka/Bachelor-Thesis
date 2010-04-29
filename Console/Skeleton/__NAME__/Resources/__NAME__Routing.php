<?php

return array(

	'controller-action' => array(
		'pattern' => '{controller}/{action}'
	),

	'controller' => array(
		'pattern' => '{controller}',
		'parameters' => array(
			'action' => 'index',
		)
	),

	'home' => array(
		'pattern' => '/',
		'parameters' => array(
			'controller' => 'default',
			'action'     => 'index',
		)
	)
);
