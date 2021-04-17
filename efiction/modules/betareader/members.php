<?php 
if (!defined('e107_INIT')) { exit; }
list($field_id, $field_title) = dbrow(dbquery("SELECT field_id, field_title FROM ".TABLEPREFIX."fanfiction_authorfields WHERE field_name = 'betareader'"));
 