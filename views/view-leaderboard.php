<?php
	namespace CRD\Core;

	// Build ranks
	$rank_weekly = (!empty($this->bag->weekly))? true : false;
	$rankings = new \CRD\Leaderboard\GameRankings($this->app, $rank_weekly);

	$title = (!$rank_weekly)? 'Last 30 days' : 'This week';
	$no_results = (!$rank_weekly)? 'There have been no races in the last 30 days' : 'There have been no races this week';
?>
			<h2><a href="#reload" class="reload" role="button">Reload</a> <?= $title ?></h2>

<?php
	// No games to show
	if (empty($rankings->results))
	{
?>
			<p><?= $no_results ?></p>
<?php
	}
	
	// Show leaderboard
	else
	{
?>
			<table>
				<tbody>
<?php
		$class = '';
		$position = 0;
		$position_previous = 0;

		foreach ($rankings->results as $id => $result)
		{
			$class = ($result->wins >= $result->losses)? 'positive' : 'negative';
			$position = $result->position;
?>
					<tr class="<?= $class ?>" data-wins-losses="<?= $result->wins, '-', $result->losses ?>" data-games-behind="<?= $result->games_behind ?>">
						<th><?= ($position !== $position_previous)? $position . '.' : '' ?></th>
						<td><?= $result->name ?></td>
					</tr>
<?php
			$position_previous = $position;
		}
?>
				</tbody>
			</table>
<?php
	}
	
	// Show add button
	if ($rank_weekly)
	{
?>
			<button class="add">+ Add race</button>
<?php
	}
?>