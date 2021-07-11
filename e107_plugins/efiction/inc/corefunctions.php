<?php
// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
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

if (!defined('e107_INIT')) { exit; }

// Sanitizes user input to help prevent XSS attacks 
function descript($text) {
  return e107::getParser()->toDB($text);
}

// Checks that the given $num is actually a number.  Used to help prevent XSS attacks.
function isNumber($num) {
  return e107::getParser()->filter($num, 'int');
}

// Formats error messages sent back from various forms and actions
function write_error($str) {
 return e107::getMessage()->addError($str)->render();
}

// Format for messages sent back from various forms and actions
function write_message($str) {
 return e107::getMessage()->addInfo($str)->render();
}