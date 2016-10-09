CREATE TABLE IF NOT EXISTS `feeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `feed_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `pubDate` datetime DEFAULT NULL,
  `guid` varchar(255) DEFAULT NULL,
  `feed` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`feed`) REFERENCES `feeds` (`id`)
);
