<?php 
             
class fanfiction_panels_ui extends e_admin_ui
{
    protected $pluginTitle		= 'efiction';
    protected $pluginName		= 'efiction';
    //	protected $eventName		= 'efiction-fanfiction_messages'; // remove comment to enable event triggers in admin.
    protected $table			= 'fanfiction_panels';
    protected $pid				= 'panel_id';
    protected $perPage			= 100;
    protected $batchDelete		= true;
    protected $batchExport     = true;
    protected $batchCopy		= true;

    protected $listOrder		= 'panel_type ASC, panel_order DESC';
    //large, xlarge, xxlarge, block-level
    protected $fields 		= array(
            'checkboxes'              => array(  'title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' =>  array(),  'writeParms' =>  array(),),

            'panel_id'              => array(  'title' => LAN_ID,  'data' => 'int',  'forced' => true,),

			'panel_type'            => array(  'title' => _TYPE,  'type' => 'dropdown',  'data' => 'str' ,  'filter'=> true),
            
			'panel_name'            => array(  'title' => _NAME,  'type' => 'text',  'data' => 'safestr',  'width' => 'auto',  'inline' => false,  'required' => true,
            'help' => ''),

            'panel_title'           => array(  'title' => _TITLE, 'type' => 'text',  'data' => 'str', 'writeParms' =>  array('size'=>'xxlarge'),   ),

			'panel_url' => array(  'title' => _PANELURL,  'type' => 'text',  'writeParms' =>  array('size'=>'xxlarge'),  'data' => 'str' ),
			'panel_hidden' => array(  'title' => _HIDDEN,  'type' => 'boolean',  'data' => 'int',  'filter'=> true  ),


			'panel_order'           => array(  'title' => LAN_ORDER,  'type' => 'number',  'data' => 'int' ),

            'options'                 => array(  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' =>  array(),  'writeParms' =>  array(),),
        );
        
    protected $fieldpref = array('panel_type',  'panel_name', 'panel_title', 'panel_url', 'panel_hidden', 'panel_order' );
        

    //	protected $preftabs        = array('General', 'Other' );
    protected $prefs = array(
        );

    
    public function init()
    {
 
		if($warning = efiction_panels::get_removed_panels()) {
			echo $warning;
		}
		
		$this->postFilterMarkup = $this->AddButton(); 

		$paneltypes = array("A" => "[A] "._ADMIN, "U" => "[U]"._USERACCOUNT, "P" => "[P] "._PROFILE, "F" => "[F] "._FAVOR, "S" => "[S] "._SUBMISSIONS, "B" => "[B] "._BROWSE, "L" => "[L] "._10LISTS,  "M" => "[M] "._MEMBERS);

		//panel_type
		$this->fields['panel_type']['writeParms']['optArray'] = $paneltypes;
    }

	function AddButton()
	{
	$text .= "</fieldset></form><div class='e-container'>
	<table id='.$pid.' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
	$text .=  
	'<a href="'.e_SELF.'?mode='.$this->getMode().'&action=create"  
	class="btn btn-success"><span>'._ADDPANEL.'</span></a><br>&nbsp;';
	$text .= "</td></tr></table></div><form><fieldset>";
	return $text;
  }		
 
}
 
class fanfiction_ratings_form_ui extends e_admin_form_ui
{
}