<?php
$options = array(
    'fields' => array(
        'template' => array(
            'title' => _TEMPLATE,
            'type' => 'textarea',
            'writeParms' => array('size'=> 'block-level')
    	),   
        'style' => array(
            'title' => _DISPLAY,
            'type' => 'radio',
            'writeParms' => array('0'=> _CHART , '1'=> _NARRATIVE, '2'=> _VARIABLES) 
    	),
    )
);
