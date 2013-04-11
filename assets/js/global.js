/* ---------------------------------------
	Game launcher
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

	// Typekit fonts
	CRD.typekit.init({ kitId: 'vpq4ijb' });

	// Init MM helper
	MM.init();