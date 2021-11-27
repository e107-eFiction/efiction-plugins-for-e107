<?php

define("EFICTION_COMMENTS_DIR",  e_PLUGIN_ABS."efiction_comments/"); 

if(e_ADMIN_AREA === true)  {}  //USER_AREA is not defined
else { 
	e107::getSingleton('efiction_comments', e_PLUGIN.'efiction_comments/classes/comments.class.php');
}