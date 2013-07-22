<?php

/*
	Routing table
	----------------------------------- */

	namespace CRD\Core;

	// Start router
	$app->router = new Router($app);

	// Home
	$app->router->add('home', '/', array('view' => 'view-home'), function($view)
	{
		$view->template = new Template($view->app, 'template-page', 'page-home');
	});

	// Weekly leaderboard
	$app->router->add('leaderboard-weekly', '/leaderboard/weekly/', array('view' => 'view-leaderboard'), function($view)
	{
		$view->bag->weekly = true;
	});

	// Default leaderboard
	$app->router->add('leaderboard-daily', '/leaderboard/default/', array('view' => 'view-leaderboard'), function($view)
	{
		$view->bag->weekly = false;
	});

	// Add game
	$app->router->add('game-add', '/game/add/', array('view' => 'view-add-game'));

	// Check request matches a route
	$app->router->check();
?>