<?php
	namespace CRD\Core;

	$resources = $template->resources;
	$html = $template->html;
	$app = $template->app;

?><!doctype html>
<html lang="<?= $html->entities($resources->locale) ?>">
	<head>
		<meta charset="utf-8">
		<title><?= $html->entities(((!empty($template->title))? $template->title . ' — ' : '') . $app->name) ?></title>

		<!-- Handheld support -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSS includes -->
		<link rel="stylesheet" href="assets/css/game.css?cache=<?= urlencode($app->version) ?>">

		<!-- Initialise advanced UI -->
		<script>document.documentElement.className = 'wf-loading advanced';</script>
	</head>
	<body class="<?= $html->entities($template->page) ?>">

		<div id="container">
<?= $template->content('main') ?>
		</div>

		<!-- Script includes -->
		<script src="assets/js/3rd-party/jquery-1.8.3.min.js"></script>
		<script src="assets/js/3rd-party/head.load.min.js"></script>
		<script src="assets/js/3rd-party/typekit-loader.min.js"></script>

		<!-- Leaderboard functionality -->
		<script src="assets/js/global.js?cache=<?= urlencode($app->version) ?>"></script>
		<script src="assets/js/game-leaderboard.js?cache=<?= urlencode($app->version) ?>"></script>
		<script src="assets/js/game-dialogue.js?cache=<?= urlencode($app->version) ?>"></script>
		<script src="assets/js/game.js?cache=<?= urlencode($app->version) ?>"></script>
	</body>
</html>