<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Leaderboard;

	class GameScore
	{
		public $name = '';
		public $position = null;
		public $wins = 0;
		public $losses = 0;
		public $differential = 0;
		public $games_behind = 0;
		
		public function __construct($name = '')
		{
			$this->name = $name;
		}
		
		public function scores($wins = 0, $losses = 0)
		{
			$this->wins = $wins;
			$this->losses = $losses;
		}
		
		public function standing($lead_wins = 0, $lead_losses = 0)
		{
			// Multiple differential by win-loss difference
			$this->differential = $this->wins / ($this->wins + $this->losses);
			$this->games_behind = (($lead_wins - $lead_losses) - ($this->wins - $this->losses)) / 2;
		}
	}
?>