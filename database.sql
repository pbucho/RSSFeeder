CREATE TABLE IF NOT EXISTS `feeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `href` varchar(255) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `feed_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `pubDate` datetime DEFAULT NULL,
  `offset` varchar(5) NOT NULL DEFAULT '+0000',
  `guid` varchar(255) DEFAULT NULL,
  `isPermaLink` tinyint(1) NULL DEFAULT NULL,
  `feed` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`feed`) REFERENCES `feeds` (`id`)
);

CREATE TABLE IF NOT EXISTS `users` (
	`id` int(11) NOT NULL,
	`name` varchar(25) NOT NULL,
	`password` varchar(255) NOT NULL,
	`registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`last_login` datetime,
	`last_ip` varchar(255),
	PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `authentication` (
  `token` varchar(50) NOT NULL,
  `owner` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiry` datetime DEFAULT NULL,
  PRIMARY KEY (`token`),
  FOREIGN KEY (`owner`) REFERENCES `users` (`id`)
);
