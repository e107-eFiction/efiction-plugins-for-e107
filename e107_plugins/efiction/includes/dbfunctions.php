<?php
 
function dbquery($query) { 
    return e107::getDb()->gen($query); 
}

function dbnumrows($query) {
 return e107::getDb()->rowCount($query);
}

function dbassoc($sql) {
  return e107::getDb()->fetch("assoc");
}

function dbinsertid($tablename = 0) {
 return e107::getDb()->lastInsertId();
}

function dbrow($sql) {
  return e107::getDb()->fetch('num') ; 
}

function dbclose() {
 /* it is done by db handler automatically, just not have this fails */
 e107::getDb()->close();
}

// Used to escape text being put into the database.
function escapestring($str) {
   if (!is_array($str)) return e107::getDb()->escape($str);
   return array_map('escapestring', $str);
}
 