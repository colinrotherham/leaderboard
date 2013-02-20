<?php

/*
	Application config
	----------------------------------- */

	namespace CRD\Core;

	// Default timezone
	date_default_timezone_set('Europe/London');

	// Start the app
	$app = new App($path);

	// App name, also cache prefix
	$app->name = 'Leaderboard';
	
	// Set app version string
	$app->version = '1.2';
	
	// MySQL connection settings
	$app->credentials->host = 'localhost';
	$app->credentials->database = 'leaderboard';
	$app->credentials->username = 'sample';
	$app->credentials->password = 'password';

	// Page templates
	$app->templates = array
	(
		'page'		=> '/templates/template-page.php'
	);

	// Add queries config
	require_once ($path . '/config.queries.php');
?>