<?php
             
class fanfiction_ratings_ui extends e_admin_ui
{
    protected $pluginTitle		= 'efiction';
    protected $pluginName		= 'efiction';
    //	protected $eventName		= 'efiction-fanfiction_messages'; // remove comment to enable event triggers in admin.
    protected $table			= 'fanfiction_ratings';
    protected $pid				= 'rid';
    protected $perPage			= 10;
    protected $batchDelete		= true;
    protected $batchExport     = true;
    protected $batchCopy		= true;

    protected $listOrder		= 'rid DESC';
    
    protected $fields 		= array(
            'checkboxes'              => array(  'title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' =>  array(),  'writeParms' =>  array(),),
            'rid'              => array(  'title' => _RATING,  'data' => 'int',  'width' => '5%',  'help' => '',  'readParms' =>  array(),  'writeParms' =>  array(),  'class' => 'left',  'thclass' => 'left', 'forced' => true,),
            'rating'            => array(  'title' => _NAME,  'type' => 'text',  'data' => 'safestr',  'width' => 'auto',  'inline' => false,  'required' => true,
            'help' => _HELP_RATING),

            'ratingwarning'           => array(  'title' => _WARNINGPOP,  'type' => 'boolean',  'data' => 'int',  'help' =>_HELP_RATINGWARNING, 'writeParms' =>  array('size'=>'block-level'),  'class' => 'left',  ),

			'ageconsent' => array(  'title' => _AGECHECK,  'type' => 'boolean',  'data' => 'int', 'help' =>_HELP_RATINGCONSENT),
			'rusersonly' => array(  'title' => _RUSERSONLY,  'type' => 'boolean',  'data' => 'int', 'help' =>_HELP_RATINGUSERS),

            'warningtext'            => array(  'title' => _WARNINGTEXT,  'type' => 'textarea',  'data' => 'str',  'width' => 'auto',  'help' => _HELP_RATINGWARNTEXT,  'readParms' => 'expand=...&truncate=150&bb=1',   'writeParms' =>  array(),  'class' => 'left',  'thclass' => 'left',),
            'options'                 => array(  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' =>  array(),  'writeParms' =>  array(),),
        );
        
    protected $fieldpref = array('rid', 'rating', 'ageconsent', 'rusersonly', 'ratingwarning', 'warningtext' );
        

    //	protected $preftabs        = array('General', 'Other' );
    protected $prefs = array(
        );

    
    public function init()
    {
		$this->postFilterMarkup = $this->AddButton(); 
    }

	function AddButton()
	{
	$text .= "</fieldset></form><div class='e-container'>
	<table id='.$pid.' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
	$text .=  
	'<a href="'.e_SELF.'?mode='.$this->getMode().'&action=create"  
	class="btn btn-success"><span>'._ADDRAT.'</span></a><br>&nbsp;';
	$text .= "</td></tr></table></div><form><fieldset>";
	return $text;
  }		
 
}
 
class fanfiction_ratings_form_ui extends e_admin_form_ui
{
}