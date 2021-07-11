<?php
$options = array(
    'fields' => array(
    
        'target' => array(
            'title' => _TARGETDATE,
            'type' => 'text',
            'help' => "",
            'writeParms' => array('size'=> "block-level", "default"=> date("m/d/Y G:H"))
        ),  
    
        'CDformat' => array(
            'title' => _FORMATCOUNT,
            'type' => 'text',
            'writeParms' => array('size'=> "block-level", "default"=> _COUNTDOWNFORMAT)
        ),
        
        'finish' => array(
            'title' => _FINISHMESSAGE,
            'type' => 'text',
            'writeParms' => array('size'=> "block-level", "default"=> _COUNTDOWNOVER)
    	),
        
    )
);
