CREATE TABLE `fanfiction_blocks` (
  `block_id` int(11) NOT NULL auto_increment,
  `block_name` varchar(30) NOT NULL default '',
  `block_title` varchar(150) NOT NULL default '',
  `block_file` varchar(200) NOT NULL default '',
  `block_status` tinyint(1) NOT NULL default '0',
  `block_variables` text NOT NULL,
  PRIMARY KEY  (`block_id`),
  KEY `block_name` (`block_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
 CREATE TABLE `fanfiction_messages` (
  `message_id` int(11) NOT NULL auto_increment,
  `message_name` varchar(50) NOT NULL default '',
  `message_title` varchar(200) NOT NULL default '',
  `message_text` text,
  PRIMARY KEY  (`message_id`),
  KEY `message_name` (`message_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `fanfiction_authors` (
  `uid` int(11) NOT NULL auto_increment,
  `penname` varchar(200) NOT NULL default '',
  `realname` varchar(200) NOT NULL default '',
  `email` varchar(200) NOT NULL default '',
  `website` varchar(200) NOT NULL default '',
  `bio` text NOT NULL,
  `image` varchar(200) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `admincreated` int(11) NOT NULL default '0',
  `password` varchar(40) NOT NULL default '0',
  `user_id` int(11) NOT NULL
  PRIMARY KEY  (`uid`),
  KEY `penname` (`penname`),
  KEY `admincreated` (`admincreated`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
