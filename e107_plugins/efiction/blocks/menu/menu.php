<?php
if(!defined("e107_INIT")) exit( );

	if(isset($blocks[$block]['content'])) {
		foreach($blocks[$block]['content'] as $page) {
			if(isset($pagelinks[$page]['link'])) {
				if(empty($blocks[$block]['style'])) $content .= "<li ".($current == $page ? "id=\"menu_current\"" : "").">".$pagelinks[$page]['link']."</li>";
				else $content .= $pagelinks[$page]['link'];
			}
		}
	}
	else {
		$pages = array('home', 'recent', 'titles', 'catslink', 'series',  'authors', 'search', 'tens', 'featured', 'help', 'contactus' );
		foreach($pages as $page) {
			if(empty($pagelinks[$page])) continue;
			if(empty($blocks[$block]['style'])) $content .= "<li ".($current == $page ? "id=\"menu_current\"" : "").">".$pagelinks[$page]['link']."</li>";
			else $content .= $pagelinks[$page]['link'];
		}
	}
	if(empty($blocks[$block]['style'])) $content = "<ul id=\"nav\" class=\"efiction-menu\">$content</ul>";
	$content = $content;
?>