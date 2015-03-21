<?php
// Enter the name of the template
$templateName = 'default';

return array(
		// Paths
		'main_path' => str_replace('/app/config', '', __DIR__),
		'template_path' => __DIR__ . '/../../templates',
		'dbs_path' => __DIR__ . '/../dbs',

		// Template paths
		'maintenance_template' => __DIR__ . '/../../templates/maintenance',
		'errors_template' => __DIR__ . '/../../templates/errors',
		'site_template' => __DIR__ . '/../../templates/'.$templateName.'/main',

		'user_template' => __DIR__ . '/../../templates/'.$templateName.'/user',
		'admin_template' => __DIR__ . '/../../templates/'.$templateName.'/admin/main',

		'user_login' => __DIR__ .'/../../templates/'.$templateName.'/main',
		'admin_login' => __DIR__ .'/../../templates/'.$templateName.'/admin/login',

		// Controller and model paths
		'controllers_path' => __DIR__ . '/../../src/Controllers',
		'models_path' => __DIR__ . '/../../src/Models',

		// Commands path (The location where you want to generate console commands)
		'command_path' => __DIR__ . '/../../src/Console/Main',

		// Sessions settings
		'session' => true, // This setting enables the custom session path
		'sessions_path' => __DIR__ .'/../sessions',
		'session_life' => 86400,

		// Number of results per page
		'max_results' => 30,

		// Set timezone
		'timezone' => 'Europe/Bucharest'
	);
