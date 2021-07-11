<?php

class fanfiction_links_ui extends e_admin_ui
{
    protected $pluginTitle = LAN_PLUGIN_EFICTION_NAME ;
    protected $pluginName = 'efiction';
    //	protected $eventName		= 'efiction-fanfiction_messages'; // remove comment to enable event triggers in admin.
    protected $table = 'fanfiction_pagelinks';
    protected $pid = 'link_id';
    protected $perPage = 100;
    protected $batchDelete = true;
    protected $batchExport = true;
    protected $batchCopy = true;

    protected $listOrder = 'link_name ASC ';
    //large, xlarge, xxlarge, block-level
    protected $fields = array(
        'checkboxes' => array('title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' => array(),  'writeParms' => array(), ),

        'link_id' => array('title' => LAN_ID,  'data' => 'int',  'forced' => true, ),

        'link_name' => array('title' => _NAME,  'type' => 'text',  'data' => 'safestr',  'width' => 'auto',  'inline' => false,  'required' => true,
            'help' => ''),

        'link_text' => array('title' => _LINKTEXT, 'type' => 'text',  'data' => 'str', 'writeParms' => array('size' => 'xxlarge')),

        'link_key' => array('title' => _LINKKEY, 'type' => 'text',  'data' => 'str', 'writeParms' => array('size' => 'xxlarge')),

        'link_url' => array('title' => _URL,  'type' => 'text',  'writeParms' => array('size' => 'xxlarge'),  'data' => 'str'),
        'link_target' => array('title' => _TARGET,  'type' => 'boolean',  'data' => 'int',  'filter' => true,
            'writeParms' => array('enabled' => _NEWWINDOW, 'disabled' => _SAMEWINDOW)),

        'link_access' => array('title' => _LINKACCESS,  'type' => 'dropdown',  'data' => 'str',  'inline' => true, 'filter' => true),

        'options' => array('title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' => array(),  'writeParms' => array(), ),
    );

    protected $fieldpref = array('link_name',  'link_text', 'link_key', 'link_url', 'link_target', 'link_access');

    //	protected $preftabs        = array('General', 'Other' );
    protected $prefs = array(
    );

    public function init()
    {
        $this->postFilterMarkup = $this->AddButton();
        $link_access = array("[0] "._ALL, "[1] "._MEMBERS, "[2] "._ADMINS);
        //panel_type
        $this->fields['link_access']['writeParms']['optArray'] = $link_access;
    }

    public function AddButton()
    {
        $text .= "</fieldset></form><div class='e-container'>
	<table id='.$pid.' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
        $text .=
    '<a href="'.e_SELF.'?mode='.$this->getMode().'&action=create"  
	class="btn btn-success"><span>'._ADDNEWLINK.'</span></a><br>&nbsp;';
        $text .= '</td></tr></table></div><form><fieldset>';
        return $text;
    }
}

class fanfiction_ratings_form_ui extends e_admin_form_ui
{
}
