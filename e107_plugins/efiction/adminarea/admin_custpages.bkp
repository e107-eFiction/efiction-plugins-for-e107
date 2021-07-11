<?php

// Generated e107 Plugin Admin Area

require_once('../../../class2.php');
if (!getperms('P')) {
    e107::redirect('admin');
    exit;
}
 
require_once("admin_leftmenu.php");
                
class fanfiction_custpages_ui extends e_admin_ui
{
    protected $pluginTitle		= 'efiction';
    protected $pluginName		= 'efiction';
    //	protected $eventName		= 'efiction-fanfiction_messages'; // remove comment to enable event triggers in admin.
    protected $table			= 'fanfiction_messages';
    protected $pid				= 'message_id';
    protected $perPage			= 10;
    protected $batchDelete		= true;
    protected $batchExport     = true;
    protected $batchCopy		= true;

    //	protected $sortField		= 'somefield_order';
    //	protected $sortParent      = 'somefield_parent';
    //	protected $treePrefix      = 'somefield_title';

    //	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.
        
    protected $listQry      	= "SELECT * FROM `#fanfiction_messages` 	
	WHERE message_name != 'welcome'  AND message_name != 'nothankyou' AND message_name != 'thankyou' 
	  AND message_name != 'copyright' AND message_name != 'printercopyright' "; 
    
    protected $listOrder		= 'message_id DESC';
    
    protected $fields 		= array(
            'checkboxes'              => array(  'title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' =>  array(),  'writeParms' =>  array(),),
            'message_id'              => array(  'title' => LAN_ID,  'data' => 'int',  'width' => '5%',  'help' => '',  'readParms' =>  array(),  'writeParms' =>  array(),  'class' => 'left',  'thclass' => 'left', 'forced' => true,),
            'message_name'            => array(  'title' => LAN_SEFURL,  'type' => 'text',  'data' => 'safestr',  'width' => 'auto',  'inline' => false,  'required' => true,
            'help' => '',  'readParms' =>  array(),  'writeParms' =>  array(),  'class' => 'left',  'thclass' => 'left',),
            'message_title'           => array(  'title' => LAN_TITLE,  'type' => 'text',  'data' => 'safestr',  'width' => 'auto',  'inline' => true,  'help' => '',  'readParms' =>  array(),  'writeParms' =>  array('size'=>'block-level'),  'class' => 'left',  'thclass' => 'left',),
            'message_text'            => array(  'title' => LAN_DESCRIPTION,  'type' => 'bbarea',  'data' => 'str',  'width' => 'auto',  'help' => '',  'readParms' => 'expand=...&truncate=150&bb=1',   'writeParms' =>  array(),  'class' => 'left',  'thclass' => 'left',),
            'options'                 => array(  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' =>  array(),  'writeParms' =>  array(),),
        );
        
    protected $fieldpref = array('message_name', 'message_title');
        

    //	protected $preftabs        = array('General', 'Other' );
    protected $prefs = array(
        );

    
    public function init()
    {
       

		if ($this->getAction() === 'edit') {
            if ($this->getID() <= 10) {
                $this->fields['message_name']['readonly'] = true;
            }
        }
    }

        
    // ------- Customize Create --------
        
    public function beforeCreate($new_data, $old_data)
    {
        $this->beforeUpdate($new_data, $old_data, null);

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
        if (empty($new_data['message_name'])) {
            $new_data['message_name'] = eHelper::title2sef($new_data['message_title']);
        } else {
            $new_data['message_name'] = eHelper::secureSef($new_data['message_name']);
        }
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
        $text = LAN_EFICTION_CUSTPAGENOTE;

        return array('caption'=>$caption,'text'=> $text);
    }
   
}
                


class fanfiction_custpages_form_ui extends e_admin_form_ui
{
}
        
        
new efiction_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;
