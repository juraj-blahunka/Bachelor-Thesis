<?php

return array(
	'constants' => array(
		'my.constant' => '1',
		'my.second'   => '2',
	),
	'components' => array(
		'MyComponent' => array(
			'class' => 'My_Special_Component',
			'constructor' => array(
				array('value', 'my value'),
				array('constant', 'my.constant'),
				array('component', 'Other'),
			),
			'methods' => array(
				array('resolve', array(
					array('constant', 'my.second')
				)),
				array('otherMethod', array())
			),
			'notes' => array(
				'remember' => 'this',
				'controller.load' => 'resolve',
			),
			'scope' => 'transient',
		),
		'Other' => array(

		)
	)
);
