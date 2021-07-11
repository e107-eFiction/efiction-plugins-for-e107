 CREATE TABLE `fanfiction_ratings` (
  `rid` int(11) NOT NULL auto_increment,
  `rating` varchar(60) NOT NULL default '',
  `ratingwarning` int(1) NOT NULL default 0,
  `ageconsent` 	  int(1) NOT NULL default 0,
  `rusersonly` 	  int(1) NOT NULL default 0,
  `warningtext` text NOT NULL,
  PRIMARY KEY  (`rid`),
  KEY `rating` (`rating`)
) ENGINE=InnoDB;