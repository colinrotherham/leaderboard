<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Leaderboard;

	class Game
	{
		private $database;
		private $players;

		public function __construct($app)
		{
			$this->app = $app;
			$this->app->database->Connect();

			// Handle POSTs
			if (!empty($_POST))
			{
				$this->submit();
			}
			
			// Don't handle
			else $this->fail(GameError::$generic);
		}
		
		private function submit()
		{
			$winner = $this->playerCheck($_POST['winner']);
			$loser = $this->playerCheck($_POST['loser']);

			// Same players
			if ($winner === $loser)
			{
				$this->fail(GameError::$duplicate);
			}
			
			$this->create($winner, $loser);
		}
		
		private function create($winner, $loser)
		{
			// Save game
			$submit_query = sprintf($this->app->queries->add_game, $winner, $loser);
			$submit_result = $this->app->database->Query($submit_query);

			// Row added?
			if ($submit_result)
			{
				$this->success();
			}
			
			else
			{
				$this->fail(GameError::$database);
			}
		}
		
		private function playerCheck($player)
		{
			if (empty($player))
			{
				$this->fail(GameError::$missing);
			}
			
			// Attempt parse
			else
			{
				// Existing player by ID
				if (is_numeric($player))
				{
					$player = $this->playerCheckId($player);
				}
				
				// New player as string
				else if (is_string($player))
				{
					$player = $this->playerCheckString($player);
				}
			}
			
			return $player;
		}
		
		private function playerCheckId($player_id)
		{
			if (!is_object($this->players))
				$this->players = new GamePlayers($this->app);

			// Convert to int
			$player_id = intval($player_id);

			// Valid player ID
			if (!array_key_exists($player_id, $this->players->list))
			{
				$this->fail(GameError::$generic);
			}

			return $player_id;
		}
		
		private function playerCheckString($player)
		{
			if (!is_object($this->players))
				$this->players = new GamePlayers($this->app);

			if (in_array($player, $this->players->list))
			{
				// Already added this player, switch to ID
				$player = array_search($player, $this->players->list);
			}
			
			else
			{
				// Add player
				$player_submit = $this->app->database->Query(sprintf($this->app->queries->add_player, $this->app->database->Escape($player)));
				$player = $this->app->database->connection->insert_id;
				
				if (empty($player))
				{
					$this->fail(GameError::$database);
				}
			}

			return $player;
		}
		
		private function success()
		{
			\CRD\Core\Redirect::to('/');
		}
		
		private function fail($type)
		{
			\CRD\Core\Redirect::to('/?error=' . $type);
		}
	}
?>