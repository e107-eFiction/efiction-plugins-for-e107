<?php

e107::lan('efiction',true );

class efiction_adminArea extends e_admin_dispatcher
{

	protected $modes = array(


		'main'	=> array(
			'controller' 	=> 'admin_settings_ui',
			'path' 			=> null,
			'ui' 			=> 'admin_settings_form_ui',
			'uipath' 		=> null
		),
 
		'messages'	=> array(
			'controller' 	=> 'fanfiction_messages_ui',
			'path' 			=> null,
			'ui' 			=> 'fanfiction_messages_form_ui',
			'uipath' 		=> null
		),
		
		'blocks'	=> array(
			'controller' 	=> 'fanfiction_blocks_ui',
			'path' 			=> null,
			'ui' 			=> 'fanfiction_blocks_form_ui',
			'uipath' 		=> null
		),
 	
	);
	
	protected $adminMenu = array(

	//	'main/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P'),  
	//	'main/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),
        'main/dasboard'		=> array('caption'=> 'SETTINGS', 'perm' => 'P',  'perm' => '0', 'url'=>'admin_settings.php'),    
        'divider2'          => array('divider'=>	true),
        'messages/list'		=> array('caption'=> LAN_EFICTION_CUSTPAGES, 'perm' => 'P',  'perm' => '0', 'url'=>'admin_messages.php'),  
		'messages/create'	=> array('caption'=> LAN_EFICTION_ADDCUSTPAGE, 'perm' => 'P',  'perm' => '0', 'url'=>'admin_messages.php'),   
        'blocks/list'		=> array('caption'=> LAN_EFICTION_BLOCKS, 'perm' => 'P',  'perm' => '0', 'url'=>'admin_blocks.php'),  
		'blockscreate'		=> array('caption'=> LAN_EFICTION_ADDBLOCK, 'perm' => 'P',  'perm' => '0', 'url'=>'admin_blocks.php'),         
 
		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),
		
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'efiction';  
 
}

 