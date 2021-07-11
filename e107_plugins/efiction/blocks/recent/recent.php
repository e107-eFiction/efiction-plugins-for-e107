<?php
	$template = e107::getTemplate('efiction', 'blocks', 'recent', true, true);

    $blocks = efiction_blocks::get_blocks();
 
    $caption = $blocks['recent']['title'];
	$var = array('BLOCK_CAPTION' => $caption);
	$caption = e107::getParser()->simpleParse($template['caption'], $var);

    $sc = e107::getScParser()->getScObject('story_shortcodes', 'efiction', false);
    $text = '';
 
    $limit 		= isset($blocks['recent']['num']) && $blocks['recent']['num'] > 0 ? $blocks['recent']['num'] : 10;
	$sumlength  = isset($blocks['recent']['sumlength']) && $blocks['recent']['sumlength'] > 0 ? $blocks['recent']['sumlength'] :75;

    $query = _STORYQUERY." ORDER BY stories.updated DESC LIMIT  $limit";
    $result = e107::getDb()->retrieve($query, true);
 
	$start = $template['start']; 
	$end = $template['end'];
    $tablerender= varset($template['tablerender'], '');
 
    foreach ($result as $stories) {
        if (!isset($blocks['recent']['allowtags'])) {
            $stories['summary'] = e107::getParser()->toText($stories['summary']);
        } else {
            $stories['summary'] = e107::getParser()->toHTML($stories['summary'], true, 'SUMMARY');
        }
		$stories['sumlength'] = $sumlength;
        $sc->setVars($stories);
        $text .= e107::getParser()->parseTemplate($template['item'], true, $sc);
    }

	$content =  e107::getRender()->tablerender($caption, $start.$text.$end, $tablerender, true);