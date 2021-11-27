CREATE TABLE `fanfiction_comments` (
 `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
 `comment_pid` int(10) UNSIGNED NOT NULL DEFAULT 0,  
 `comment_item_id` int(10) UNSIGNED NOT NULL DEFAULT 0,  
 `comment_subject` varchar(100) NOT NULL DEFAULT '',
 `comment_author_id` int(10) UNSIGNED NOT NULL DEFAULT 0,  
 `comment_author_name` varchar(100) NOT NULL DEFAULT '',  
 `comment_author_email` varchar(200) NOT NULL DEFAULT '',
 `comment_datestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
 `comment_comment` text NOT NULL,
 `comment_blocked` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
 `comment_ip` varchar(45) NOT NULL DEFAULT '',
 `comment_type` varchar(20) NOT NULL DEFAULT '0',
 `comment_lock` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
 `comment_share` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
 PRIMARY KEY (`comment_id`),
 KEY `comment_blocked` (`comment_blocked`),
 KEY `comment_author_id` (`comment_author_id`)
) ENGINE=InnoDB; 