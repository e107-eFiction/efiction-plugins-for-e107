<?php
$options = array(
    'fields' => array(
        'tpl' => array(
            'title' => LAN_EFICTION_BLOCKTYPE,
            'type' => 'dropdown',
            'writeParms' => array('optArray' => array(0 => LAN_EFICTION_DEFAULT, 1 => LAN_EFICTION_USETPL))  
    	),
        'allowtags' => array(
            'title' => LAN_EFICTION_TAGS,
            'type' => 'boolean',
        ),
        'sumlength' => array(
            'title' => LAN_EFICTION_SUMLENGTH,
            'type' => 'number'
        ),
        'num' => array(
            'title' => LAN_EFICTION_NUMUPDATED,
            'type' => 'number',
            'help' => LAN_EFICTION_SUMNOTE
        ),
    )
);
