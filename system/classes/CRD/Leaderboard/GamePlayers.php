<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Leaderboard;

	class GamePlayers
	{
		private $database;
		public $list = array();
	
		public function __construct()
		{
			$this->database = new \CRD\Core\Database();
			$this->database->Connect();
			
			// Database players
			$players = $this->database->Query(\CRD\Core\App::$queries->players);
			
			// Build up results objects
			while ($player = $players->fetch_object())
			{
				$this->list[$player->id] = $player->name;
			}
		}
	}
?>