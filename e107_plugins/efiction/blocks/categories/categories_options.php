<?php
$options = array(
    'fields' => array(
    
        'template' => array(
            'title' => "Default",
            'type' => 'textarea',
            'help' => "",
            'writeParms' => array('size'=> "block-level", "default"=> "{image} {link} [{count}] {description}")
        ),  
    
        'columns' => array(
            'title' => "Columns:",
            'type' => 'boolean',
            'writeParms' => array('enabled'=> _MULTICOLUMN , 'disabled'=> _ONECOLUMN)
        ),
        
        'tpl' => array(
            'title' => LAN_EFICTION_BLOCKTYPE,
            'type' => 'boolean',
            'writeParms' => array('enabled'=> LAN_EFICTION_USETPL , 'disabled'=> LAN_EFICTION_DEFAULT)
            
    	),
        
    )
);
