<?php
// ----------------------------------------------------------------------
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
if (!defined('e107_INIT')) { exit; }

// Page Setup
$current = "titles";
	$caption = _TITLES.($let ? " - $let" : "");
    $output .=  build_alphalinks("browse.php?$terms&amp;", $let)."</div>";
	if($let == _OTHER) $storyquery .= " AND stories.title REGEXP '^[^a-z]'";
	else if(!empty($let)) $storyquery .= " AND stories.title LIKE '$let%'";
	$storyquery  .= _ORDERBY;
	$numrows = search(_STORYQUERY.$storyquery, _STORYCOUNT.$storyquery, "browse.php?");