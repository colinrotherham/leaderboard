<?php

/*
	Routing table
	----------------------------------- */

	namespace CRD\Core;

	// Start router
	$app->router = new Router($app, $path);

	// Home
	$app->router->add('/', 'home', function($view)
	{
		$view->template = new Template($view, 'page', 'page-home');
	});

	// Weekly leaderboard
	$app->router->add('/leaderboard/weekly/', 'leaderboard', function($view)
	{
		$view->bag['all'] = false;
	});

	// All-time leaderboard
	$app->router->add('/leaderboard/all-time/', 'leaderboard', function($view)
	{
		$view->bag['all'] = true;
	});

	// Add game
	$app->router->add('/game/add/', 'add-game');

	// Check request matches a route
	$app->router->check();
?>