/* ---------------------------------------
	Create controller
--------------------------------------- */

	MM.Game = function()
	{
		var self = this;

		var main = $('#main');
		var rankings = $('.ranking');
		var leaderboards = [];

		// Wire up AJAX ranking
		rankings.each(function(i, element)
		{
			leaderboards.push(new MM.GameLeaderboard(i, element));
		});

		// Set up new game dialogue
		new MM.GameDialogue(main, rankings, leaderboards);
	};

	// Set up rankings
	$(window).load(function()
	{
		new MM.Game();
	});