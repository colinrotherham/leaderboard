<?php

/*
	Routing table
	----------------------------------- */

	namespace CRD\Core;

	// Start router
	$app->router = new Router($app, $path);

	// Home
	$app->router->add('/', array('view-home'), function($view)
	{
		$view->template = new Template($view, 'template-page', 'page-home');
	});

	// Weekly leaderboard
	$app->router->add('/leaderboard/weekly/', array('view-leaderboard'), function($view)
	{
		$view->bag->weekly = true;
	});

	// Default leaderboard
	$app->router->add('/leaderboard/default/', array('view-leaderboard'), function($view)
	{
		$view->bag->weekly = false;
	});

	// Add game
	$app->router->add('/game/add/', array('view-add-game'));

	// Check request matches a route
	$app->router->check();
?>