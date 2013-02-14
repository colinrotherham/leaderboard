<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Leaderboard;

	class GamePlayers
	{
		private $app;
		public $list = array();

		public function __construct($app)
		{
			$this->app = $app;
			$this->app->database->Connect();

			// Database players
			$players = $this->app->database->Query($this->app->queries->players);

			// Build up results objects
			while ($player = $players->fetch_object())
			{
				$this->list[$player->id] = $player->name;
			}
		}
	}
?>