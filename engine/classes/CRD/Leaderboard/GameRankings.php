<?php

/*
	Copyright (c) 2012 Colin Rotherham, http://colinr.com
	https://github.com/colinrotherham
*/

	namespace CRD\Leaderboard;

	class GameRankings
	{
		public $results = array();

		private $results_wins;
		private $results_losses;

		private $app;
		private $database;
		
		private $rank_all;

		public function __construct($app, $rank_all = true)
		{
			$this->app = $app;
			$this->app->database->Connect();

			// Rank all or just weekly?
			$this->rank_all = $rank_all;

			$this->query();

			// Continue if not empty
			if (!empty($this->results_wins->num_rows) && !empty($this->results_losses->num_rows))
			{
				$this->results();
				
				// Process standings then rank
				$this->standings();
				$this->rankings();
			}
		}

		private function query()
		{
			// Optional WHERE clause when narrowing to current week
			$where_clause = ($this->rank_all)? '' : $this->app->queries->clause_week;

			// Database results
			$this->results_wins = $this->app->database->Query(sprintf($this->app->queries->wins, $where_clause));
			$this->results_losses = $this->app->database->Query(sprintf($this->app->queries->losses, $where_clause));
		}

		public function results()
		{
			// Build up results objects
			while ($win = $this->results_wins->fetch_object())
			{
				// Create new score object for wins
				$result = new GameScore($win->name);
				$result->scores($win->wins, 0);

				// Add to array
				$this->results[$win->id] = $result;
			}

			// Append losses
			while ($loss = $this->results_losses->fetch_object())
			{
				// Never won a game, create new score object
				if (empty($this->results[$loss->id]))
					$this->results[$loss->id] = new GameScore($loss->name);

				$result = $this->results[$loss->id];
				$result->scores($result->wins, $loss->losses);
			}
			
			// Sort object by wins
			usort($this->results, array($this, 'sort_wins_losses'));
		}

		public function standings()
		{
			if (count($this->results) > 0)
			{
				// Determine top players wins/losses for games-behind
				$lead_wins = $this->results[0]->wins;
				$lead_losses = $this->results[0]->losses;

				// Loops results object, calculate differential
				foreach ($this->results as $id => $result)
				{
					$result->standing($lead_wins, $lead_losses);
				}
			}
		}
		
		public function rankings()
		{
			$rank = 0;
			$rank_previous = 0;
			$position = 0;
		
			// Determine rank by differential - games behind
			usort($this->results, array($this, 'sort_rank'));

			foreach ($this->results as $id => $result)
			{
				$rank = $result->differential - $result->games_behind;
			
				// Increment position when rank has changed
				if ($rank !== $rank_previous || $position === 0)
					$position++;

				// Save rank for the next sweep
				$rank_previous = $rank;
				
				$this->results[$id]->position = $position;
			}
		}

		public function sort_wins_losses($a, $b)
		{
			return ($a->wins - $a->losses) < ($b->wins - $b->losses);
		}

		public function sort_rank($a, $b)
		{
			return ($a->differential - $a->games_behind) < ($b->differential - $b->games_behind);
		}
	}
?>