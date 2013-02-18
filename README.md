Game Rankings
=============

This is an AJAX-driven leaderboard app (built on Tiny Engine, https://github.com/colinrotherham/tiny-engine/)
for ranking "All Time" and "Weekly" plays for most two-player games.

Running the leaderboard
-----------------------

* Set up a new MySQL database and configure credentials here:

```
	/config.php
```

* Import the database structure + dummy content from:

```
	/leaderboard, structure.sql
	/leaderboard, content.sql
```

* Set up a new Apache website, point to the root of this project

* Visit the site in your browser, it should look like this:

![Sample leaderboard](https://raw.github.com/colinrotherham/leaderboard/master/assets/img/sample.png)
