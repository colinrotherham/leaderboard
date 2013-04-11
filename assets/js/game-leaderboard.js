/* ---------------------------------------
	Game leaderboard
--------------------------------------- */

	MM.GameLeaderboard = function(i, element)
	{
		var self = this;

		var parent, placeholder, spinner;

		function init()
		{
			parent = $(element);
			placeholder = parent.children('.placeholder');
			spinner = parent.children('.spinner');

			// Enable reload button
			parent.on('click', '.reload', reload);

			// Delay spinner drop
			reload();
		}

		function update()
		{
			spinner.addClass('drop');

			setTimeout(function()
			{
				placeholder.load(parent.data('src'), function()
				{
					parent.addClass('loaded');
					spinner.hide();
				});

			}, 150);
		}

		function reload(event)
		{
			var delay = (MM.isMobile)? 300 : (i + 1) * 300;

			if (event)
			{
				// Don't delay clicks, UI feels slow
				if (event.type === 'click') delay = 0;

				// Don't follow click
				event.preventDefault();
			}

			// 2nd load?
			if (parent.hasClass('loaded'))
			{
				parent.removeClass('loaded');

				// Show spinner, fade in
				setTimeout(function() { spinner.show(); }, 200);
				setTimeout(function() { spinner.removeClass('drop'); }, 250);

				// Delay AJAX
				delay += 1000;
			}

			// AJAX update
			setTimeout(update, delay);
		}

		// Make reload method public
		self.reload = reload;

		init();
	};