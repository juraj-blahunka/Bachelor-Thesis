<?php

return array(
	'constants' => array(
		'application.cache'     => dirname(__FILE__).'/../Cache',
		'application.logs'      => dirname(__FILE__).'/../Logs',
		'application.logs.file' => dirname(__FILE__).'/../Logs/{{ name }}.log',
	),
	'components' => array(

		'logger_handler_service' => array(
			'class' => 'FileLogMessageHandler',
			'constructor' => array(
				array('constant', 'application.logs.file'),
				array('component', 'DefaultLogMessageFormatter')
			)
		),

		'controller_view_listener' => array(
			'class' => 'TwigViewLoadListener',
			'notes' => array(
				'listener' => array(
					array('controller.view', 'handle')
				)
			)
		)

	)
);
