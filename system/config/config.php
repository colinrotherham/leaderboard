<?php

/*
	Application config
	----------------------------------- */

	use \CRD\Core\App as App;
	use \CRD\Core\Resource as Resource;

	// Default timezone
	date_default_timezone_set('Europe/London');

	// App name, also cache prefix
	App::$name = 'Game Leaderboard';
	
	// Set app version string
	App::$version = '1.1';

	// MySQL connection settings
	App::$credentials->host = 'localhost';
	App::$credentials->database = 'leaderboard';
	App::$credentials->username = 'sample';
	App::$credentials->password = 'password';

	// Page templates
	App::$templates = array
	(
		'page'		=> '/templates/template-page.php'
	);

	// Set up locale
	Resource::locale('en-GB');
?>