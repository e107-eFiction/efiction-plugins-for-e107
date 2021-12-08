# eFiction Series plugin


## Administration of eFiction series by e107 Admin UI


Notes:
- added one field primary index (before combination serie ID + story ID)

ALTER TABLE `e107_fanfiction_inseries` ADD `inseriesid` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD INDEX `inseriesid` (`inseriesid`);

TODO:

- allowseries  option replaced by plugin installation
 0 - admins
 1 - authors
 2 - all members

 
 







