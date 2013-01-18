<?php
	require_once ('../system/config/classes.php');

	use \CRD\Core\Template as Template;
	use \CRD\Leaderboard\GamePlayers as GamePlayers;

	$players = new GamePlayers();

	// Apply template
	Template::create('page', 'page-home');

	// Start placeholder
	Template::placeHolder('main');	

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
			<div id="main" role="main"<?php if ($is_invalid) echo ' class="mask"'; ?>>

				<h1>Metro Mario</h1>
	
				<!-- Totals, all-time -->
				<div class="ranking ranking-total" data-src="/leaderboard/all-time/">
					<p class="spinner busy"><span class="icon"></span> Loading all-time</p>
					<div class="placeholder"></div>
				</div>
	
				<!-- Totals, this week -->
				<div class="ranking ranking-weekly" data-src="/leaderboard/weekly/">
					<p class="spinner busy"><span class="icon"></span> Loading weekly</p>
					<div class="placeholder"></div>
				</div>
			</div>
			
			<!-- Add race -->
			<div class="popup<?php if ($is_invalid) echo ' show'; ?>">
				<button class="close">x</button>
			
				<h2>Add race</h2>

				<div id="error-generic" class="error<?php if ($is_invalid_generic) echo ' show'; ?>">
					<p>Sorry, we couldn’t add that game. Please try again…
				</div>
				
				<div id="error-missing" class="error<?php if ($is_invalid_missing) echo ' show'; ?>">
					<p>Sorry, looks like you’ve missed a player…
				</div>
				
				<div id="error-duplicate" class="error<?php if ($is_invalid_duplicate) echo ' show'; ?>">
					<p>Sorry, looks like you’ve picked duplicate players…
				</div>
				
				<div id="error-database" class="error<?php if ($is_invalid_database) echo ' show'; ?>">
					<p>Sorry, we couldn’t add this game to the database…
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
	Template::placeHolderEnd();
?>
