<?php
	namespace CRD\Core;

	require_once ('../system/config/classes.php');

	use \CRD\Leaderboard\GamePlayers as GamePlayers;
	use \CRD\Leaderboard\GameError as GameError;

	$players = new GamePlayers($app);
	$template = new Template($app, 'page', 'page-home');

	// Start placeholder
	$template->placeHolder('main');	

	// An error occurred?
	$is_invalid = (isset($_GET['error']))? true : false;

	$is_invalid_generic = false;
	$is_invalid_missing = false;
	$is_invalid_duplicate = false;
	$is_invalid_database = false;

	// Other errors
	if (!empty($_GET['error']))
	{
		if ($_GET['error'] == GameError::$generic) $is_invalid_generic = true;
		if ($_GET['error'] == GameError::$missing) $is_invalid_missing = true;
		if ($_GET['error'] == GameError::$duplicate) $is_invalid_duplicate = true;
		if ($_GET['error'] == GameError::$database) $is_invalid_database = true;
	}
?>
			<div id="main" role="main"<?= ($is_invalid)? ' class="mask"' : '' ?>>

				<h1>Metro Mario</h1>
	
				<!-- Totals, all-time -->
				<div class="ranking ranking-total" data-src="/leaderboard/all-time/">
					<p class="spinner busy"><span class="icon"></span> Loading…</p>
					<div class="placeholder"></div>
				</div>
	
				<!-- Totals, this week -->
				<div class="ranking ranking-weekly" data-src="/leaderboard/weekly/">
					<p class="spinner busy"><span class="icon"></span> Loading…</p>
					<div class="placeholder"></div>
				</div>
			</div>
			
			<!-- Add game -->
			<div class="popup<?= ($is_invalid)? ' show' : '' ?>">
				<button class="close">x</button>
			
				<h2>Add game</h2>

				<div id="error-generic" class="error<?= ($is_invalid_generic)? ' show': '' ?>">
					<p>Sorry, we couldn’t add that race. Please try again…</p>
				</div>
				
				<div id="error-missing" class="error<?= ($is_invalid_missing)? ' show' : '' ?>">
					<p>Sorry, looks like you’ve missed a player…</p>
				</div>
				
				<div id="error-duplicate" class="error<?= ($is_invalid_duplicate)? ' show' : '' ?>">
					<p>Sorry, looks like you’ve picked duplicate players…</p>
				</div>
				
				<div id="error-database" class="error<?= ($is_invalid_database)? ' show' : '' ?>">
					<p>Sorry, we couldn’t add this race to the database…</p>
				</div>

				<form method="post" action="/game/add/">
					<div>
						<label for="winner">Winner <a class="new-player" href="#not-listed" role="button">+ Add new player</a></label>
						<select id="winner" name="winner">
							<option value="">Select player…</option>
<?php foreach ($players->list as $player_id => $player) : ?>
							<option value="<?= $player_id ?>"><?= $player ?></option>
<?php endforeach; ?>
							
						</select>
					</div>
					<div>
						<label for="loser">Loser <a class="new-player" href="#not-listed" role="button">+ Add new player</a></label>
						<select id="loser" name="loser">
							<option value="">Select player…</option>
<?php foreach ($players->list as $player_id => $player) : ?>
							<option value="<?= $player_id ?>"><?= $player ?></option>
<?php endforeach; ?>
						</select>
					</div>
					
					<button type="submit">Submit</button>
				</form>
			</div>
<?php
	// End placeholder
	$template->placeHolderEnd();
?>
