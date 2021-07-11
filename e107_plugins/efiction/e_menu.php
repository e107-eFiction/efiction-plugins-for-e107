<?php
/*
* e107 website system
*
* Copyright (C) 2008-2015 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
*
*/

if (!defined('e107_INIT')) {
    exit;
}

e107::lan('efiction', true);

class efiction_menu
{
    public function __construct()
    {
    }

    /**
     * Configuration Fields.
     * @return array
     */
    public function config($menu = '')
    {
        $fields = array();
        $blocks = efiction_blocks::get_blocks();

    	foreach($blocks AS $key => $block) {
			$availableblocks[$key] = $block['title'];
		}

        switch ($menu) {
			case 'blocks':
				
				$fields['block_name'] = array('title' => LAN_EFICTION_BLOCKS,  'type' => 'dropdown', 'writeParms' => array('optArray' => $availableblocks), 'help' => '');
		/*		$fields['block_caption'] = array('title' => LAN_CAPTION, 'type' => 'text', 'multilan' => true, 'writeParms' => array('size' => 'xxlarge'));
				$fields['block_TableStyle'] = array('title' => 'Tablestyle', 'type' => 'text', 'writeParms' => array('size' => 'xxlarge'));
		*/
				return $fields;
				break;
				 
				
			}
    }
}
