/* ---------------------------------------
	Create game dialogue
--------------------------------------- */

	MM.GameDialogue = function(main, rankings, leaderboards)
	{
		var self = this;

		var popup, form, formHTML;
		var errors, errorGeneric, errorMissing, errorDuplicate, errorDatabase;
		var winner, loser, button;

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
			button = form.children('button');
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
			$.each(list, function(id, player)
			{
				id = id.replace('id: ', '');
				fragment.innerHTML += '<option value="' + id + '">' + player + '</option>';
			});

			// Update with new HTML
			winner.html(fragment.innerHTML);
			loser.html(fragment.innerHTML);

			// Save HTML for later
			formHTML = form.html();
		}

		function gameCreate(event)
		{
			button.attr('disabled', 'disabled');
		
			// Submit using AJAX
			$.ajax(
			{
				url: form.attr('action'),
				data: form.serialize(),
				dataType: 'json',
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
				close(undefined, function()
				{
					button.removeAttr('disabled');

					// Rebuild players
					if (response.players)
					{
						playerUpdate(response.players);
					}
				});
			}

			// AJAX successful but server says fail
			else gameCreateError(response);
		}
		
		function gameCreateError(response)
		{
			errors.hide();
			button.removeAttr('disabled');

			// Show matching error in UI
			if (response.error && errorsList[response.error])
				errorsList[response.error].show();
		}

		init();
	};