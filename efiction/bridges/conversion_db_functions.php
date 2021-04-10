<?php


function dbquery($query) {
 
	 return e107::getDb()->gen($query);
}


function dbnumrows($query) {
  return e107::getDb()->rowCount($query);
}


function dbassoc($query, $multi = false  ) {
  //if $fields is of type boolean and $where is not found, $fields overrides $multi
  if($multi == true) {
		 return e107::getDb()->retrieve($query, $multi );
	}
	else {
	   return  e107::getDb()->fetch();    
	}
}


function dbrow($query, $multi = false ) {  
  while($row = e107::getDb()->fetch())        
  {  
    $ret[] = $row;
	}
  
  if($multi == false) {
	 
	   	return array_shift($ret);   
	}
  else {
     return  $ret ;  
  } 
 
}    

function dbrow2() {  
  return  e107::getDb()->fetch();    
}    


function dbclose() {
	e107::getDb()->close();
}


// Used to escape text being put into the database.
function escapestring($str) {
	 
   if (!is_array($str)) return e107::getDb()->escape($str);
   return array_map('escapestring', $str);
}


?>