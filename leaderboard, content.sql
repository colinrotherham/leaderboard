# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.25)
# Database: leaderboard
# Generation Time: 2013-01-23 20:22:31 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table games
# ------------------------------------------------------------

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`id`, `modified`, `winnerId`, `loserId`)
VALUES
	(1,'2013-01-06 21:42:19',1,2),
	(2,'2013-01-06 21:42:19',1,2),
	(3,'2013-01-06 21:42:19',1,2),
	(4,'2013-01-06 21:42:19',2,5),
	(5,'2013-01-06 21:42:19',5,3),
	(6,'2013-01-06 21:42:19',4,8),
	(7,'2013-01-11 20:37:43',4,3),
	(8,'2013-01-12 13:02:55',4,6),
	(9,'2013-01-12 13:03:08',1,4),
	(10,'2013-01-12 13:03:22',4,5),
	(11,'2013-01-12 13:04:05',4,5),
	(12,'2013-01-12 13:04:23',4,5),
	(13,'2013-01-12 13:04:35',5,2),
	(14,'2013-01-12 13:08:00',1,5),
	(15,'2013-01-18 01:47:30',2,1),
	(16,'2013-01-18 01:48:57',2,1),
	(17,'2013-01-18 01:49:04',2,3),
	(18,'2013-01-18 01:49:12',1,2),
	(19,'2013-01-18 01:49:21',10,2),
	(20,'2013-01-18 11:17:42',4,3);

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table players
# ------------------------------------------------------------

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;

INSERT INTO `players` (`id`, `name`)
VALUES
	(10,'Andrew Smith'),
	(1,'Andy Atkinson'),
	(2,'Berty Bryant'),
	(3,'Christine Cauldwell'),
	(4,'David Dean'),
	(5,'Eileen Earnest'),
	(6,'Freddy Fitzpatrick'),
	(7,'Gareth Gray'),
	(8,'Helen Holiday'),
	(9,'Ian Indigo');

/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
