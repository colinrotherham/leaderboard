<?php

/*
	MySQL query config
	----------------------------------- */

	namespace CRD\Core;

	// Base wins
	$app->queries->wins = "

		SELECT
		
			players.id,
			players.name,
			SUM(CASE WHEN games.winnerId = players.id THEN 1 ELSE 0 END) AS wins

		FROM games
		
		JOIN players ON (games.winnerId = players.id)

		%s
		GROUP BY players.id
		ORDER BY players.id DESC
	";

	// Base losses
	$app->queries->losses = "

		SELECT

			players.id,
			players.name,
			SUM(CASE WHEN games.loserId = players.id THEN 1 ELSE 0 END) AS losses

		FROM games
		
		JOIN players ON (games.loserId = players.id)
		
		%s
		GROUP BY players.id
		ORDER BY players.id DESC
	";

	// Create weekly queries
	$app->queries->wins_week = sprintf($app->queries->wins, 'WHERE YEARWEEK(modified,1) = YEARWEEK(NOW(),1)');
	$app->queries->losses_week = sprintf($app->queries->losses, 'WHERE YEARWEEK(modified,1) = YEARWEEK(NOW(),1)');

	// Create default queries
	$app->queries->wins = sprintf($app->queries->wins, 'WHERE modified BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()');
	$app->queries->losses = sprintf($app->queries->losses, 'WHERE modified BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()');

	// Players
	$app->queries->players = "
	
		SELECT
			
			players.id,
			players.name
		
		FROM players
		ORDER BY players.name
	";
	
	// Add game
	$app->queries->add_game = "
	
		INSERT INTO games (winnerId, loserId)
		VALUES(?, ?)
	";
	
	// Add player
	$app->queries->add_player = "
	
		REPLACE INTO players (name)
		VALUES(?)
	";