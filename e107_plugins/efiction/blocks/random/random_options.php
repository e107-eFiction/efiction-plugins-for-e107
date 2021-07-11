<?php
$options = array(
    'fields' => array(
        'tpl' => array(
            'title' => LAN_EFICTION_BLOCKTYPE,
            'type' => 'boolean',
            'writeParms' => array('enabled'=> LAN_EFICTION_USETPL , 'disabled'=> LAN_EFICTION_DEFAULT)
            
    	),
        'allowtags' => array(
            'title' => LAN_EFICTION_TAGS,
            'type' => 'boolean',
            'writeParms' => array('enabled'=> _ALLOWTAGS , 'disabled'=> _STRIPTAGS)
        ),
        'sumlength' => array(
            'title' => LAN_EFICTION_SUMLENGTH,
            'help' => _SUMNOTE,
            'type' => 'number',
            'writeParms' => array('help'=> LAN_EFICTION_SUMNOTE)
        ),
        
    )
);
