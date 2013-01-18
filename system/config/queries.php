<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	use \CRD\Core\App as App;

	// Narrow to current week
	App::$queries->clause_week = "WHERE YEARWEEK(modified,1) = YEARWEEK(NOW(),1)";

	// Wins
	App::$queries->wins = "

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

	// Losses
	App::$queries->losses = "

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
	
	// Players
	App::$queries->players = "
	
		SELECT
			
			players.id,
			players.name
		
		FROM players
		ORDER BY players.name
	";
	
	// Add game
	App::$queries->add_game = "
	
		INSERT INTO games (winnerId, loserId)
		VALUES(%s, %s)
	";
	
	// Add player
	App::$queries->add_player = "
	
		REPLACE INTO players (name)
		VALUES('%s')
	";