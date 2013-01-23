<?php
	use \CRD\Core\App as App;
	use \CRD\Core\Template as Template;
	use \CRD\Core\Resource as Resource;
	use \CRD\Core\HTML as HTML;

?><!doctype html>
<html lang="<?= HTML::entities(Resource::$locale) ?>">
	<head>
		<meta charset="utf-8">
		<title><?= HTML::entities(((!empty(Template::$title))? Template::$title . ' — ' : '') . App::$name) ?></title>

		<!-- Handheld support -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSS includes -->
		<link rel="stylesheet" href="/assets/css/game.css?cache=<?= urlencode(App::$version) ?>">
		
		<!-- Initialise advanced UI -->
		<script>document.documentElement.className = 'wf-loading advanced';</script>
	</head>
	<body class="<?= HTML::entities(Template::$name) ?>">
	
		<div id="container">
<?= Template::content('main') ?>
		</div>
		
		<!-- Script includes -->
		<script src="/assets/js/3rd-party/jquery-1.8.3.min.js"></script>
		<script src="/assets/js/3rd-party/head.load.min.js"></script>
		<script src="/assets/js/3rd-party/typekit-loader.min.js"></script>

		<!-- Leaderboard functionality -->
		<script src="/assets/js/game.js?cache=<?= urlencode(App::$version) ?>"></script>
	</body>
</html>