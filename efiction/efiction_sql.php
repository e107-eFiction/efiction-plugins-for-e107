 CREATE TABLE `fanfiction_messages` (
  `message_id` int(11) NOT NULL auto_increment,
  `message_name` varchar(50) NOT NULL default '',
  `message_title` varchar(200) NOT NULL default '',
  `message_text` text,
  PRIMARY KEY  (`message_id`),
  KEY `message_name` (`message_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;