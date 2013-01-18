Game Rankings
=============

This is an AJAX-driven leaderboard app (built on Tiny Engine, https://github.com/colinrotherham/tiny-engine/)
for ranking "All Time" and "Weekly" plays for most two-player games.

Running the leaderboard
-----------------------

1. Set up a new MySQL database as configure credentials here:

```
	/system/config/config.php
```

2. Import the database structure + dummy content from:

```
	/leaderboard.sql
```

3. Set up a new Apache website, point to the root of this project