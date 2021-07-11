<?php

if (!defined('e107_INIT')) { exit; }

$template = e107::getTemplate('efiction', 'blocks', 'random', true, true);
$blocks = efiction_blocks::get_blocks();

$caption = $blocks['random']['title'];
$var = array('BLOCK_CAPTION' => $caption);
$caption = e107::getParser()->simpleParse($template['caption'], $var);

$sc = e107::getScParser()->getScObject('story_shortcodes', 'efiction', false);
$text = '';

$limit = isset($blocks['random']['limit']) && $blocks['random']['limit'] > 0 ? $blocks['random']['limit'] : 1;
$sumlength  = isset($blocks['random']['sumlength']) && $blocks['random']['sumlength'] > 0 ? $blocks['random']['sumlength'] :75;

$query = _STORYQUERY." ORDER BY rand( ) DESC LIMIT $limit";
$result = e107::getDb()->retrieve($query, true);

$start = $template['start']; 
$end = $template['end'];
$tablerender= varset($template['tablerender'], '');

foreach ($result as $stories) {
	if (!isset($blocks['random']['allowtags'])) {
		$stories['summary'] = e107::getParser()->toText($stories['summary']);
	} else {
		$stories['summary'] = e107::getParser()->toHTML($stories['summary'], true, 'SUMMARY');
	}
	$$stories['sumlength'] = $sumlength ;
	$sc->setVars($stories);
	$text .= e107::getParser()->parseTemplate($template['item'], true, $sc);
}

$content =  e107::getRender()->tablerender($caption, $start.$text.$end, $tablerender, true);