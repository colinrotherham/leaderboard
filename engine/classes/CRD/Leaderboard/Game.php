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
		
		private $is_ajax = false;
		private $is_new_player = false;

		public function __construct($app)
		{
			$this->app = $app;
			$this->app->database->Connect();

			// Handle POSTs
			if (!empty($_POST))
				$this->submit();

			// Don't handle
			else $this->fail(GameError::$generic);
		}
		
		private function submit()
		{
			// Is this request AJAX?
			$this->is_ajax = $this->app->router->is_ajax();

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
			$submit_params = array
			(
				array('d', $winner),
				array('d', $loser)
			);

			// Save game
			$submit_query = $this->app->queries->add_game;
			$submit_result = $this->app->database->Query($submit_query, $submit_params);

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
				$player_param = array('s', $this->app->database->Escape($player));
				$player_submit = $this->app->database->Query($this->app->queries->add_player, array($player_param));

				// Grab new player ID
				$player = $this->app->database->connection->insert_id;

				if (empty($player))
				{
					$this->fail(GameError::$database);
				}

				// Mark as new player added
				$this->is_new_player = true;
			}

			return $player;
		}
		
		private function success()
		{
			if ($this->is_ajax)
			{
				$response = array('success' => true);

				// Append updated player list?
				if ($this->is_new_player)
				{
					// Get fresh player list
					$players = new GamePlayers($this->app);

					/*
						Browsers don't order object keys consistently,
						convert keys to string first ('id: N')
					*/

					$list = array();
					foreach ($players->list as $id => $player)
					{
						$list['id: ' . $id] = $player;
					}

					// Add to JSON
					$response['players'] = $list;
				}

				// Output JSON
				echo json_encode($response);
				exit;
			}

			else $this->app->redirect->to('/');
		}
		
		private function fail($type)
		{
			if ($this->is_ajax)
			{
				$response = array('success' => false, 'error' => $type);
			
				// Output JSON
				echo json_encode($response);
				exit;
			}

			else $this->app->redirect->to('/?error=' . $type);
		}
	}
?>