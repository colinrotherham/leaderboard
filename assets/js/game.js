/* ---------------------------------------
	Game Leaderboard
--------------------------------------- */

	var MM =
	{
		// Overridden when resizing
		isMobile: true,

		resize: function()
		{
			MM.isMobile = ($(window).width() < 465)? true : false;
		},

		resizeDelay: function()
		{
			if (MM.resizeTimer)
			{
				clearTimeout(MM.resizeTimer);
			}

			MM.resizeTimer = setTimeout(MM.resize, 500);
		},

		init: function()
		{
			// Update isMobile
			$(window).resize(MM.resizeDelay);
			MM.resize();
		}
	};

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
			setTimeout(function()
			{
				// AJAX leaderboard load
				update(parent, placeholder, spinner);

			}, (MM.isMobile)? 300 : (i + 1) * 300);
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
			parent.removeClass('loaded');

			// Show spinner, fade in
			setTimeout(function() { spinner.show(); }, 200);
			setTimeout(function() { spinner.removeClass('drop'); }, 250);
			setTimeout(function() { update(parent, placeholder, spinner); }, 1000);

			event.preventDefault();
		}

		init();
	};

	MM.GameDialogue = function(main, rankings)
	{
		var self = this;

		var popup, form, formHTML;
		var errors, errorGeneric, errorMissing, errorDuplicate, errorDatabase;
		var winner, loser;

		function init()
		{
			popup = $('.popup');
			form = $('form');

			// Individual errors
			errors = popup.find('.error');
			errorGeneric = $('#error-generic');
			errorMissing = $('#error-missing');
			errorDuplicate = $('#error-duplicate');
			errorDatabase = $('#error-database');

			// Input fields
			winner = $('#winner');
			loser = $('#loser');

			// Save HTML for later
			formHTML = form.html();

			// Wire up new game dialogue
			popup.on('click', '.close', close);
			popup.on('click', '.new-player', createPlayer);

			// invoke dialogue when button clicked
			rankings.on('click', '.add', open);

			// Form submit
			//$('form').submit(createGame);
		}

		function open(event)
		{
			form.html(formHTML);
			errors.hide();

			popup.css('display', 'block');
			main.addClass('mask');

			// Fade in using CSS
			setTimeout(function()
			{
				popup.addClass('show').attr('tabindex', '-1').focus();

			}, 50);

			event.preventDefault();
		}

		function close(event)
		{
			popup.removeClass('show');
			main.removeClass('mask');

			// Hide using JS
			setTimeout(function()
			{
				popup.hide();
				$('button.add').focus();

			}, 200);

			event.preventDefault();
		}

		function createPlayer(event)
		{
			var link = $(this);
			var select = link.parent().next();
			var input = $('<input>').attr({ type: 'text', name: select.attr('name'), id: select.attr('id'), placeholder: 'Player name…' });

			// Re-assigns variable for validation
			switch(select.attr('id'))
			{
				case 'winner':
				winner = input; break;

				case 'loser':
				loser = input; break;
			}

			select.replaceWith(input);
			link.remove();

			setTimeout(function()
			{
				input.focus();

			}, 50);

			event.preventDefault();
		}

		function createGame(event)
		{
			event.preventDefault();
		}

		init();
	};

	MM.Game = function()
	{
		var self = this;

		var main = $('#main');
		var rankings = $('.ranking');

		// Wire up AJAX ranking
		rankings.each(function(i, element) { new MM.GameLeaderboard(i, element); });

		// Set up new game dialogue
		new MM.GameDialogue(main, rankings);
	};

	// Init MM helper
	MM.init();

	// Typekit fonts
	CRD.typekit.init({ kitId: 'vpq4ijb' });

	// Set up rankings
	$(window).load(function()
	{
		new MM.Game();
	});