<?php

e107::lan('efiction',true, true);

class efiction_adminArea extends e_admin_dispatcher
{

	protected $modes = array(


		'main'	=> array(
			'controller' 	=> 'fanfiction_messages_ui',
			'path' 			=> null,
			'ui' 			=> 'fanfiction_messages_form_ui',
			'uipath' 		=> null
		),

		'tools'	=> array(
			'controller' 	=> 'fanfiction_messages_ui',
			'path' 			=> null,
			'ui' 			=> 'fanfiction_messages_form_ui',
			'uipath' 		=> null
		),
		
 
		'messages'	=> array(
			'controller' 	=> 'fanfiction_messages_ui',
			'path' 			=> null,
			'ui' 			=> 'fanfiction_messages_form_ui',
			'uipath' 		=> null
		),
		

 	
	);
	
	protected $adminMenu = array(

	//	'main/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P'),  
	//	'main/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),
    //    'divider2'          => array('divider'=>	true),
        'messages/list'		=> array('caption'=> LAN_EFICTION_CUSTPAGES, 'perm' => 'P',  'perm' => '0', 'url'=>'admin_messages.php'),  
		'messages/create'	=> array('caption'=> LAN_EFICTION_ADDCUSTPAGE, 'perm' => 'P',  'perm' => '0', 'url'=>'admin_messages.php'),   
        
 
		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),
		
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'efiction';  
 
}

 