<?php
	require_once ('../system/config/classes.php');

	use \CRD\Leaderboard\GameRankings as GameRankings;

	// All times or just weekly?
	define('SHOW_ALL', (isset($_GET['all']))? true : false);
	
	// Build ranks	
	$rankings = new GameRankings();
	
	$title = (SHOW_ALL)? 'All-time' : 'This week';
	$no_results = (SHOW_ALL)? 'There have been no games yet' : 'There have been no games this week';
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
		$position = 0;
		$position_previous = 0;

		foreach ($rankings->results as $id => $result)
		{
			$position = $result->position;
?>
					<tr data-wins="<?= $result->wins ?>" data-losses="<?= $result->losses ?>" data-games-behind="<?= $result->games_behind ?>">
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
	if (!SHOW_ALL)
	{
?>
			<button class="add">+ Add game</button>
<?php
	}
?>