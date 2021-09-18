<?php
// ----------------------------------------------------------------------
// eFiction 3.2
// Copyright (c) 2007 by Tammy Keefer
// Valid HTML 4.01 Transitional
// Based on eFiction 1.1
// Copyright (C) 2003 by Rebecca Smallwood.
// http://efiction.sourceforge.net/
// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------

if(!defined("e107_INIT")) exit( );
 
$uid = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : false;
if(!$uid) $uid = USERUID;
    
$user_id = efiction_authors::get_user_id_by_author_uid($uid);


$userData = e107::user(USERID);  //logged in user

if($user_id) {

    if (USERID == $user_id)
    {
    	$url = e107::getUrl()->create('user/myprofile/edit');
        e107::redirect($url); 
    }
    else if(ADMIN && getperms("4") && !$userData['user_admin'])
    {
    	
        
        $url =  e_ADMIN_ABS."users.php?mode=main&action=edit&id=".$user_id;
        print_a($url); die;
        e107::redirect($url); 
    }
    else {
       var_dump(ADMIN);   var_dump(getperms("4")); var_dump($userData['user_admin']);  die;
       $output .= write_error("(1)"._ERROR);
    }
 
     
}
else {
 
   $output .= write_error("(2)"._ERROR);
} 



 
        
     