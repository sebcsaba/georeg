<?php

return config_merge(array(

	'lifecycle' => 'unknown', // values: production, development, test
	
	'di' => array(
		'impl' => array(
			'EventLoadService' => 'EventLoadServiceImpl',
		),
		'nonsingletons' => array(
		),
		'specials' => array(
			'Database' => new DatabaseDIHandler(),
		),
	),
	
	'messages' => array(
		'title.error' => 'Sorry.',
		'general.error' => 'An error occured. Please contact the site administrator!',
	),
	
	'default.error.page' => 'default.error',

),require_once('config.local.php'));
