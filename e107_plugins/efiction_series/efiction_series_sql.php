CREATE TABLE `fanfiction_inseries` (
 `inseriesid` int(11) NOT NULL AUTO_INCREMENT,	
 `seriesid` int(11) NOT NULL default '0',
 `sid` int(11) NOT NULL default '0',
 `subseriesid` int(11) NOT NULL default '0',
 `confirmed` int(11) NOT NULL default '0',
 `inorder` int(11) NOT NULL default '0',
 `updated` int(11) NOT NULL default '0',
 PRIMARY KEY (`sid`,`seriesid`),
 KEY `seriesid` (`seriesid`,`inorder`),
 KEY `ID` (`inseriesid`)
) ENGINE=InnoDB;

CREATE TABLE `fanfiction_series` (
 `seriesid` int(11) NOT NULL auto_increment,
 `title` varchar(200) NOT NULL default '',
 `summary` text,
 `uid` int(11) NOT NULL default '0',
 `isopen` tinyint(4) NOT NULL default '0',
 `catid` varchar(200) NOT NULL default '0',
 `rating` tinyint(4) NOT NULL default '0',
 `classes` varchar(200) default NULL,
 `characters` varchar(250) NOT NULL default '',
 `reviews` smallint(6) NOT NULL default '0',
 `numstories` int(11) NOT NULL default '0',
 `warnings` varchar(250) NOT NULL default '',
 `challenges` varchar(200) NOT NULL default '',
 `genres` varchar(250) NOT NULL default '',
 `image` varchar(100) NOT NULL,
 `seriessef` varchar(200) NOT NULL default '', 
 `series_allow_comments` tinyint(3) unsigned NOT NULL default '0',
 `series_comment_total` int(10) unsigned NOT NULL default '0', 
 PRIMARY KEY (`seriesid`),
 KEY `catid` (`catid`),
 KEY `characters` (`characters`),
 KEY `classes` (`classes`),
 KEY `owner` (`uid`,`title`)
) ENGINE=InnoDB;
