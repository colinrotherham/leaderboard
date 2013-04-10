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

	MM.GameDialogue = function(main, rankings, leaderboards)
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
			errorsList = [];
			
			errorsList['generic'] = $('#error-generic');
			errorsList['missing'] = $('#error-missing');
			errorsList['duplicate'] = $('#error-duplicate');
			errorsList['database'] = $('#error-database');

			initFields();
			initEvents();

			// Save HTML for later
			formHTML = form.html();
		}

		function initFields()
		{
			// Input fields
			winner = $('#winner');
			loser = $('#loser');
		}

		function initEvents()
		{
			// Wire up new game dialogue
			popup.on('click', '.close', close);
			popup.on('click', '.new-player', playerCreate);

			// invoke dialogue when button clicked
			rankings.on('click', '.add', open);

			// Form submit
			form.submit(gameCreate);
		}
		
		function reset()
		{
			form.html(formHTML);
			errors.hide();
			
			initFields();
		}

		function open(event)
		{
			reset();

			popup.css('display', 'block');
			main.addClass('mask');

			// Fade in using CSS
			setTimeout(function()
			{
				popup.addClass('show');
				winner.focus();

			}, 50);

			if (event) event.preventDefault();
		}

		function close(event, callback)
		{
			popup.removeClass('show');
			main.removeClass('mask');

			// Hide using JS
			setTimeout(function()
			{
				popup.hide();
				$('button.add').focus();

				// Optional callback? E.g. Update players
				if (callback) callback();

			}, 200);

			if (event) event.preventDefault();
		}

		function playerCreate(event)
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

			if (event) event.preventDefault();
		}

		function playerUpdate(list)
		{
			reset();

			// Create new player list with 'Please select' option
			var fragment = document.createDocumentFragment();
			fragment.innerHTML = '<option>' + winner.children('option').first().html() + '</option>';

			// Add each player to list
			$.each(list, function(i, player)
			{
				fragment.innerHTML += '<option value="' + i + '">' + player + '</option>';
			});

			// Update with new HTML
			winner.html(fragment.innerHTML);
			loser.html(fragment.innerHTML);

			// Save HTML for later
			formHTML = form.html();
		}

		function gameCreate(event)
		{
			// Submit using AJAX
			$.ajax(
			{
				url: form.attr('action'),
				data: form.serialize(),
				dataType: 'json',
				ifModified: true,
				type: 'POST',

				// Success handler
				success: gameCreateSuccess
			});

			// Don't do regular submit
			if (event) event.preventDefault();
		}
		
		function gameCreateSuccess(response)
		{
			if (response.success)
			{
				// Reload all leaderboards
				$.each(leaderboards, function(i, leaderboard) { leaderboard.reload(); });

				// Close dialogue, update players
				close(undefined, function() { playerUpdate(response.players); });
			}

			// AJAX successful but server says fail
			else gameCreateError(response);
		}
		
		function gameCreateError(response)
		{
			errors.hide();

			// Show matching error in UI
			if (response.error && errorsList[response.error])
				errorsList[response.error].show();
		}

		init();
	};

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

	// Init MM helper
	MM.init();

	// Typekit fonts
	CRD.typekit.init({ kitId: 'vpq4ijb' });

	// Set up rankings
	$(window).load(function()
	{
		new MM.Game();
	});