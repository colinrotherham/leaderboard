<?php

/*
	Application config
	----------------------------------- */

	namespace CRD\Core;

	// Default timezone
	date_default_timezone_set('Europe/London');

	// App name, also cache prefix
	$app->name = 'Metro Mario';
	
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
	
	// Page partials
	$app->partials = array
	(
		'address'	=> '/views/partials/partial-address.php'
	);

	// Set up locale
	$app->resources->locale('en-GB');
?>