<?php

return config_merge(array(

	'lifecycle' => 'unknown', // values: production, development, test
	
	'db' => array(
		'protocol' => 'mysql',
	),
	
	'di' => array(
		'impl' => array(
			'AuthenticationService' => 'GeoRegAuthenticationServiceImpl',
			'ApplicationHandler' => 'NormalApplicationHandlerImpl',
			'DbDialect' => 'MySqlDbDialect',
			'DbEngine' => 'MySqlDbEngine',
			
			'EventLoadService' => 'EventLoadServiceImpl',
			'EventAdminService' => 'EventAdminServiceImpl',
			'ParticipantAdminService' => 'ParticipantAdminServiceImpl',
			'ParticipantLoadService' => 'ParticipantLoadServiceImpl',
			
			'EventLoadDaoService' => 'EventLoadDaoServiceImpl',
			'EventAdminDaoService' => 'EventAdminDaoServiceImpl',
			'ParticipantLoadDaoService' => 'ParticipantLoadDaoServiceImpl',
			'ParticipantAdminDaoService' => 'ParticipantAdminDaoServiceImpl',
			
			'EventAuthService' => 'EventAuthServiceImpl',
			'ParticipantAuthService' => 'ParticipantAuthServiceImpl',
		),
		'nonsingletons' => array(
		),
		'specials' => array(
			'TranslationHandler' => new TranslationHandlerDIHandler(),
			'Database' => new DatabaseDIHandler(),
		),
	),
	
	'messages' => array(
		'title.error' => 'Sorry.',
		'general.error' => 'An error occured. Please contact the site administrator!',
	),
	
	'language' => array(
		'enabled' => true,
		'installed' => array('hu','en'),
		'default' => 'hu',
	),
	
	'default.error.page' => 'default.error',

),require_once('config.local.php'));
