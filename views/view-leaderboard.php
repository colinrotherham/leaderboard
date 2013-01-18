<?php
	require_once ('../system/config/classes.php');

	use \CRD\Leaderboard\GameRankings as GameRankings;

	// All times or just weekly?
	define('SHOW_ALL', (isset($_GET['all']))? true : false);
	
	// Build ranks	
	$rankings = new GameRankings();
	
	$title = (SHOW_ALL)? 'All-time' : 'This week';
	$no_results = (SHOW_ALL)? 'There have been no races yet' : 'There have been no races this week';
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
<?
		$position = 0;
		$previous_rank = 0;

		foreach ($rankings->results as $id => $result)
		{
			// Same score as last person, don't increment position
			if ($previous_rank === $result->differential - $result->games_behind)
			{
				$position_display = '';
			}
			
			// Increment position
			else
			{
				$position++;
				$position_display = "{$position}.";
			}
?>
					<tr>
						<th><?= $position_display ?></th>
						<td><?= $result->name ?></td>
						<!--<td><?= $result->wins ?></td>
						<td><?= $result->losses ?></td>
						<td><?= $result->games_behind ?></td>-->
					</tr>
<?php
			$previous_rank = $result->differential - $result->games_behind;
		}
?>
				</tbody>
			</table>
<?php
	}
	
	// Show add button
	if (!SHOW_ALL)
	{
?>
			<button class="add">+ Add race</button>
<?php
	}
?>