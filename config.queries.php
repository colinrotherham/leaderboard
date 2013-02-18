<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Core;

	// Narrow to current week
	$app->queries->clause_week = "WHERE YEARWEEK(modified,1) = YEARWEEK(NOW(),1)";

	// Wins
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

	// Losses
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
		VALUES(%s, %s)
	";
	
	// Add player
	$app->queries->add_player = "
	
		REPLACE INTO players (name)
		VALUES('%s')
	";