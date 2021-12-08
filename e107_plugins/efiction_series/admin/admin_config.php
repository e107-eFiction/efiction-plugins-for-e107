<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// Language Files ///////////////////////////////////////////////
e107::lan('efiction');
e107::lan('efiction', true);

/////////////////////////////////////////////////////////////////

//fix for checkboxes look */

$ret  ="  .checkbox-inline {min-width: 300px;}
#characters-container .checkbox-inline  {margin-left: 20px!important; } 
#catid-container .checkbox-inline  {margin-left: 20px!important; }  
#classes-container .checkbox-inline  {margin-left: 20px!important; } 
 ";

e107::css("inline", $ret) ;


// Functions Files //////////////////////////////////////////////
 
 
class efiction_series_adminArea extends e_admin_dispatcher
{ 
 
	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'fanfiction_series_ui',
			'path' 			=> null,
			'ui' 			=> 'fanfiction_series_form_ui',
			'uipath' 		=> null
		),

		'inseries'	=> array(
			'controller' 	=> 'fanfiction_inseries_ui',
			'path' 			=> null,
			'ui' 			=> 'fanfiction_inseries_form_ui',
			'uipath' 		=> null
		),		
		

	);	
	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> _SERIES, 'perm' => 'P'),
		'main/create'		=> array('caption'=> _ADDSERIES, 'perm' => 'P'),
		'inseries/list'		=> array('caption'=> "Stories in series", 'perm' => 'P'),
		'inseries/create'	=> array('caption'=> "Add story to serie", 'perm' => 'P'),
		
	);

	protected $adminMenuAliases = array(
		'inseries/edit'	=> 'main/list',
		'inseries/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = _MANAGESERIES;
}
 		
class fanfiction_series_ui extends e_admin_ui
{
			
		protected $pluginTitle		= _MANAGESERIES;
		protected $pluginName		= 'efiction_series';
	//	protected $eventName		= 'efiction_series-fanfiction_series'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'fanfiction_series';
		protected $pid				= 'seriesid';
		protected $perPage			= 40; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'seriesid DESC';
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' =>  array (),  'writeParms' =>  array (),),

			'seriesid'                => array (  'title' => 'Seriesid',  'data' => 'int',  'forced'=> TRUE, 
			 'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			 'image'                   => array (  'title' => LAN_IMAGE,  'type' => 'image',  'data' => 'str',  'width' => 'auto',  'help' => '',  'readParms' => 'thumb=80x80',  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),

			'title'                   => array (  'title' => LAN_TITLE,  'type' => 'text',  'data' => 'str',  'width' => 'auto',  'inline' => true,  'help' => '',  'readParms' =>  array (),  
			'writeParms' =>  array ('size'=>'block-level'),  'class' => 'left',  'thclass' => 'left',),

			'summary'                 => array (  'title' => LAN_SUMMARY,  'type' => 'textarea',  'data' => 'str',  'width' => 'auto',  'inline' => true,  'help' => '',  'readParms' =>  array (),  
			'writeParms' =>  array ('size'=>'block-level'),  'class' => 'left',  'thclass' => 'left',),

			'uid'                     => array (  'title' => _SERIE_MANAGER,  'type' => 'dropdown',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			
			'isopen'                  => array (  'title' => _OPEN,  'type' => 'boolean',  'data' => 'int',  'width' => 'auto',  'help' => LAN_OPENNOTE,  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
                                     
			'catid'                   => array (  'title' => _CHOOSECAT,  'type' => 'checkboxes',  'data' => 'str', 
             'width' => 'auto',  'help' => '',  'readParms'=>array('type'=>'checkboxes'),  
              'writeParms' =>  array ('useKeyValues' => 1 ),  
             'class' => 'left',  'thclass' => 'left',  'filter' => true,  'batch' => false,),
   
			'rating'                  => array (  'title' => LAN_RATING,  'type' => 'dropdown',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',  'filter' => false,  'batch' => false,),

			'classes'                 => array (  'title' => 'Classes',  'type' => 'method',  'data' => 'str',  'width' => 'auto',  'help' => '',  
            'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',  'filter' => false,  'batch' => false,),

			'characters'              => array (  'title' => 'Characters',  'type' => 'checkboxes',  'data' => 'str',  'width' => 'auto',  'help' => '',  
            'readParms' =>  array (),  'writeParms' => array ('inline' => true,  'useKeyValues' => 1),  'class' => 'left',  'thclass' => 'left',  'filter' => false,  'batch' => false,),
			
			'reviews'                 => array (  'title' => 'Reviews',  'type' => 'boolean',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),

			'numstories'              => array (  'title' => 'Numstories',  'type' => 'number',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),

			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' =>  array (),  'writeParms' =>  array (),),
		);		
		
		protected $fieldpref = array('title', 'summary', 'uid', 'isopen', 'catid', 'reviews', 'numstories');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		); 

	
		public function init()
		{
			if($this->getAction() === 'list')  {
				$this->fields['catid']['title'] = LAN_CATEGORIES;
			}
			else {
				$this->fields['numstories']['type'] = "hidden";
			}	

			$this->fields['uid']['writeParms']['optArray'] =  e107::getSingleton('efiction_authors')->get_authors_list();
			$this->fields['catid']['writeParms']['optArray'] =  e107::getSingleton('efiction_categories')->get_categories_list();
			$this->fields['rating']['writeParms']['optArray'] =  e107::getSingleton('efiction_ratings')->get_ratings_list();
			$this->fields['characters']['writeParms']['optArray'] =  efiction_characters::characters();;
		 
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
		 
            $new_data['classes'] = implode(',',$new_data['classes']);
    
    
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
        
			$new_data['classes'] = implode(',',$new_data['classes']);
  
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
		// left-panel help menu area. (replaces e_help.php used in old plugins)
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = '<p>Series are collections of related stories by the same or multiple authors. 
			A story and its sequels, for example, would be a series. Series might also be 
			used for a &quot;shared universe&quot; in which multiple authors write. The 
			person who creates the series is considered the series &quot;owner&quot; and 
			controls whether or not the series is &quot;open&quot; to contributions by other 
			authors or not. Even if the series is &quot;closed&quot;, the series owner has 
			the option to include stories from other authors in the series. This form is 
			the same as members with an additional option to select the owner of the series. 
		  </p>';

			return array('caption'=>$caption,'text'=> $text);

		}			
			
}
 
class fanfiction_series_form_ui extends e_admin_form_ui
{	

 
 
	function classes($curVal, $mode  )  {
		$text = '';
		
		switch($mode)
		{
			case 'read': // List Page
			 
				$rows = e107::getDb()->retrieve("SELECT * FROM #fanfiction_classes  AS c LEFT JOIN #fanfiction_classtypes AS t ON c.class_type = t.classtype_id  ORDER by c.class_type ", true);
			
				foreach($rows AS $row) {
						$values[$row['class_id']] = $row['class_name'];
				}

				if($curVal) {		
					$classes = explode(",", $curVal ); 
					foreach($classes AS  $class) {   
						$text .= "<span class=\"btn btn-xs btn-primary\" style=\"display: inline-block;\" >".$values[$class]."</span>&nbsp;";
					}	
				}
				else $text = '';
	 
				return $text;
				break;
 
			case 'write': // Edit Page
                if(!empty($curVal)) {
                   $classes = explode(",", $curVal);
                }
				else {              
                   $classes[0] = 0;
                }
			     
				$classrows = e107::getDb()->retrieve('SELECT * FROM #fanfiction_classtypes ORDER BY classtype_name', true);
				$ret .="<style> .checkbox-inline {min-width: 300px;}
				#characters-container .checkbox-inline  {margin-left: 20px!important; } 
				#catid-container .checkbox-inline  {margin-left: 20px!important; }  
				#classes-container .checkbox-inline  {margin-left: 20px!important; } 
				</style>";
                
                $options['useKeyValues'] = true;
			    $options['inline'] = true;    
  
				foreach ($classrows as $type) {   
					$text .= "<div class='row mb-3'>";
						$text .= "<div> <label class=\"col-sm-2 col-form-label fw-bold\" for=\"class_".$type['classtype_id']."\"><b>$type[classtype_title]:</b></label></div>";
						$result2 = e107::getDb()->retrieve("SELECT * FROM #fanfiction_classes WHERE class_type = '$type[classtype_id]' ORDER BY class_name", true);
						$values = array();
						$text .= '<div class="col-sm-12">';
							foreach ($result2 as $row) {
								$values[$row['class_id']] = $row['class_name'] ;
							}
							$options['useKeyValues'] = true;
							$options['inline'] = true;
						$text .= e107::getForm()->checkboxes('classes', $values, $classes, $options);
						$text .= '</div>';
					$text .= '</div>';
				}
				return $text;
  
			break; 
 
		}
  
	}
	 	

}
 

class fanfiction_inseries_ui extends e_admin_ui
{
 

		protected $pluginTitle		= 'Series';
		protected $pluginName		= 'efiction_series';
	//	protected $eventName		= 'efiction_series-fanfiction_inseries'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'fanfiction_inseries';
		protected $pid				= 'inseriesid';
		protected $perPage			= 40; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	 //	protected $sortField	   = 'inorder';
		//protected $sortParent      = 'seriesid';
	//	protected $orderStep = 1;
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= ' inseriesid DESC';
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' =>  array (),  'writeParms' =>  array (),),

			
			'seriesid'                => array (  'title' => _SERIES,  'type' => 'dropdown',  'data' => 'int',  'width' => 'auto',  'filter' => true,  'validate' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array ('size'=>'block-level'),  'class' => 'left',  'thclass' => 'left',  'batch' => false,),
			
			'sid'                     => array (  'title' => _STORY,  'type' => 'dropdown',  'data' => 'int',  'width' => 'auto',  'filter' => true,  'validate' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array ('size'=>'block-level'),  'class' => 'left',  'thclass' => 'left',  'batch' => false,),
			
			 
			'confirmed'               => array (  'title' => _VALIDATE,  'type' => 'boolean',  'data' => 'int',  'width' => 'auto',  'filter' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			
			'inorder'                 => array (  'title' => _ORDER,  'type' => 'number',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			 
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last', 
             'class' => 'center last',  'forced' => true,  'readParms'=>array () ,  'writeParms' =>  array (),),
		);		
		
		protected $fieldpref = array('seriesid', 'sid', 'subseriesid', 'confirmed', 'inorder');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		); 

	
		public function init()
		{
 
			// Set drop-down values (if any). 
		 	$this->fields['seriesid']['writeParms']['optArray'] =  e107::getSingleton('efiction_series')->get_series_list();
			 
		 	$this->fields['sid']['writeParms']['optArray'] =  e107::getSingleton('efiction_stories')->get_full_stories_list();
 
	
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
		// left-panel help menu area. (replaces e_help.php used in old plugins)
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = _SERIESNOTE."<hr>"._SERIESNOTE2 ;

			return array('caption'=>$caption,'text'=> $text);

		}
 		
}
				


class fanfiction_inseries_form_ui extends e_admin_form_ui
{

}		
		
		
new efiction_series_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

