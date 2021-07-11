<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!e_UC_ADMIN) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('efiction');
e107::lan('efiction', true);


require_once("inc/get_session_vars.php");
 
require_once(_BASEDIR."includes/queries.php"); //TEMP Fix header.php and pagesetup.php


 
class efiction_adminArea extends e_admin_dispatcher
{

    protected $modes = array(

    		'main'	=> array(
    			'controller' 	=> 'admin_settings_ui',
    			'path' 			=> null,
    			'ui' 			=> 'admin_settings_form_ui',
    			'uipath' 		=> null
    		),
    );    
    
    protected $adminMenu = array(
    'main/index'		=> array('caption'=> LAN_EFICTION_ADMIN_PANELS,   'url'=>'admin_config.php'),    
    'main/prefs'		=> array('caption'=> LAN_PREFS   ),    
    );

	protected $menuTitle = LAN_PLUGIN_EFICTION;
 
   function init()
   {
		$panellist = efiction_panels::get_adminmenu_panels(); 
		foreach($panellist as $accesslevel => $panels) {
			$this->adminMenu[] = array(
				'header' => _LEVEL . ": ". $accesslevel 
			);

			foreach($panels as $mode => $value)
			{
	
				$action = '';
				if (empty($action))
				{
					$action = 'list';
				} 
			
				$menu = $mode . '/'.$action;
				
				if($value['type'] == "e107") { //generate modes only in e107 only way
					$this->adminMenu[$menu] = array(
						'caption' => $value['text']  ,
						'perm' => $value['perm'],
					); 
                    $this->pageTitles[$mode.'/edit'] =  LAN_EDIT;
	                $this->pageTitles[$mode.'/create'] =   $value['text'] . " - ". LAN_CREATE  ;   
					
				
					$this->modes[$mode] = array(
						'controller' => 'fanfiction_'.$mode.'_ui',
						'path' => 'adminarea/admin_'.$mode.'.php', 
						'ui' => 'fanfiction_'.$key.'_form_ui',
						'uipath' => 'adminarea/admin_'.$mode.'.php', 
					);

				}
				elseif($value['type'] == "both") {
					$this->adminMenu[$menu] = array(
						'caption' => $value['text']  ,
						'perm' => $value['perm'],
					 	'uri' => $value['link']  
					);
				}
				else  {
					$this->adminMenu[$menu] = array(
						'caption' => $value['text']  ,
						'perm' => $value['perm'],
					 	'uri' => $value['link']  
					);
				}
                
                
 
			}
		}
 	
   }
      
}
class admin_settings_ui extends e_admin_ui
{
	    protected $pluginName = 'efiction';	
		protected $pluginTitle		= LAN_PLUGIN_EFICTION;
        
        protected $prefs = array(
			'pref_author_after_login'	   				=> array('title'=> 'Auto Create Author after user login in', 'type'=>'boolean', 'data' => 'int', 'help'=>'If user doesn\'t have Author ID, new author is created after first log in'),
		);
        
         protected $adminMenuAliases = array(
    		'ratings/edit'	=> 'ratings/list'
    	);
        
		// optional - a custom page.  
		public function indexPage()
		{
			 
			if($warning = efiction_panels::get_removed_panels()) {
				echo $warning;
			}

			
			$ns = e107::getRender();
		 
		
			$panellist = efiction_panels::get_adminmenu_panels(); 
			foreach($panellist as $accesslevel => $panels) {
				$mainPanel .= '
					<div class="panel panel-default">
						<div class="panel-heading">
							  <h3 class="panel-title">Level: '.$accesslevel.'</h3>
						</div>
						<div class="panel-body">';
 
					foreach($panels AS $val) {
						$caption = $val['caption'];
						if($val['type'] == "e107") {$caption = " <i class='fa fa-check bg-success'></i> ";  }
						if($val['type'] == "both") {$caption = " <i class='fa fa-eye bg-info'></i> ";  }
						$tmp = e107::getNav()->renderAdminButton($val['link'], $val['title']. $caption, $caption, $val['perm'], $val['icon_32'], "div") ;
						$mainPanel .= $tmp;
								
					}  
					$mainPanel .= "</div>
					</div>";
				 
			}
		
	 
			e107::getRender()->tablerender($caption,   $mainPanel); 	
		}
        
        

 
}
				


class admin_settings_form_ui extends e_admin_form_ui
{

}
		
 //include ("../header.php");		

new efiction_adminArea();
 
require_once(e_ADMIN."auth.php");
 
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

/*
$action = '';
 
if(isset($_GET['action']))
{
	$action = e107::getParser()->filter($_GET['action'], 'str');
} 

 
elseif(function_exists($action))
{
	$result = call_user_func($action, $par);
}

function main($action) {
    

	$ns = e107::getRender();
    $vals = efiction_panels::get_adminarea_panels();

	foreach($vals AS $val) {
		$panelslist[$val['panel_level']][] = $val;
	}

	foreach($panelslist AS $level => $panels) {  //do it better way, don't display empty panellist
		$mainPanel .= '
		<div class="panel panel-default">
			<div class="panel-heading">
		  		<h3 class="panel-title">Level: '.$level.'</h3>
			</div>
			<div class="panel-body">';
	 
		foreach($panels AS $val) {
			$tmp = e107::getNav()->renderAdminButton($val['link'], $val['title'], $val['caption'], $val['perms'], $val['icon_32'], "div") ;
			$mainPanel .= $tmp;
					
		}  
		$mainPanel .= "</div>
		</div>";
	}
	e107::getRender()->tablerender($caption,   $mainPanel); 

}

function ratings($rid = NULL) {
  
	$output = '';
	//include(e_PLUGIN."efiction/admin/ratings.php");
	define('ADMIN_AREA', true);
	
 
	include(e_PLUGIN."efiction/adminarea/admin_ratings.php");
	new fanfiction_ratings_adminArea();
	$html =  e107::getAdminUI()->runPage("raw");
 
	$caption = $html[0]; 
	$output = $html[1];
	//e107::getRender()->tablerender($caption,   $output); 
	 
}
*/

require(e_ADMIN . 'footer.php');

 
