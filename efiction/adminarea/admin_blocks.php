<?php

// Generated e107 Plugin Admin Area

require_once '../../../class2.php';
if (!getperms('P')) {
    e107::redirect('admin');
    exit;
}

require_once 'admin_leftmenu.php';

class fanfiction_blocks_ui extends e_admin_ui
{
    protected $pluginTitle = 'efiction';
    protected $pluginName = 'efiction';
    //	protected $eventName		= 'efiction-fanfiction_blocks'; // remove comment to enable event triggers in admin.
    protected $table = 'fanfiction_blocks';
    protected $pid = 'block_id';
    protected $perPage = 20;
    protected $batchDelete = true;
    protected $batchExport = true;
    protected $batchCopy = true;

    //	protected $sortField		= 'somefield_order';
    //	protected $sortParent      = 'somefield_parent';
    //	protected $treePrefix      = 'somefield_title';

    //	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.

    //	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

    protected $listOrder = 'block_id DESC';

    protected $fields = array(
        'checkboxes' => array('title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' => array(),  'writeParms' => array(), ),
        'block_id' => array('title' => LAN_ID,  'data' => 'int',  'width' => '5%',  'help' => '',  'readParms' => array(),  'writeParms' => array(),  'class' => 'left',  'thclass' => 'left', 'forced' => true, ),
        'block_name' => array('title' => LAN_TITLE,  'type' => 'text',  'data' => 'safestr',  'width' => 'auto',  'inline' => true,  'validate' => true,  'help' => '',  'readParms' => array(),  'writeParms' => array(),  'class' => 'left',  'thclass' => 'left', ),
        'block_title' => array('title' => LAN_TITLE,  'type' => 'text',  'data' => 'safestr',  'width' => 'auto',  'inline' => true,  'help' => '',  'readParms' => array(),  'writeParms' => array(),  'class' => 'left',  'thclass' => 'left', ),

        'block_file' => array('title' => 'File',  'type' => 'text',  'data' => 'safestr',  'width' => 'auto',  'help' => '',  'readParms' => array(),  'writeParms' => array('size' => 'block-level'),  'class' => 'left',  'thclass' => 'left', ),
        'block_status' => array('title' => 'Status',  'type' => 'dropdown',  'data' => 'int',  'width' => 'auto',  'batch' => true,  'filter' => true,  'help' => '',  'readParms' => array(),
            'writeParms' => array('optArray' => array(0 => LAN_EFICTION_INACTIVE, 1 => LAN_EFICTION_ACTIVE, 2 => LAN_EFICTION_INDEXONLY)), 'class' => 'left',  'thclass' => 'left', ),

        'block_variables' => array('title' => LAN_OPTIONS,  'type' => 'method',   'data' => 'str',  'width' => 'auto',  'help' => '',  'readParms' => array(),  'writeParms' => array('nolabel' => 1),  'class' => 'left',  'thclass' => 'left',  'filter' => false,  'batch' => false, ),
        'options' => array('title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' => array(),  'writeParms' => array(), ),
    );

    protected $fieldpref = array('block_id', 'block_name', 'block_title', 'block_file', 'block_status');

    //	protected $preftabs        = array('General', 'Other' );
    protected $prefs = array(
    );

    public function init()
    {
    }

    // ------- Customize Create --------

    public function beforeCreate($new_data, $old_data)
    {
        $new_data = $this->beforeUpdate($new_data, $old_data, null);
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
        $blockvars = $new_data['block_variables'];
        $new_data['block_variables'] =  serialize($blockvars) ;

    
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
        $text = '<p>The status should generally start off as 
			0 for inactive.&nbsp; There are 3 status options for blocks: </p>
		  <div align="center">

			<center>
			<table border="1" cellpadding="5" cellspacing="0" 
			style="border-collapse: collapse" bordercolor="#111111">
			  <tr>
				<th colspan="2">Status</th>
				<th>&nbsp;Associated .tpl file</th>
				<th>Appears</th>
			  </tr>
			  <tr>
				<td>0</td>
				<td>Inactive</td>
				<td>The block is off. </td>
				<td>nowhere</td>
			  </tr>
			  <tr>
				<td>1</td>
				<td>Active</td>
				<td>The block is on.</td>
				<td>anywhere</td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>Index only</td>
				<td>index page only.</td>
				<td>anywhere on the index page.</td>
			  </tr>
			  </table>
			</center>
		  </div>
		  <p>&nbsp; </p>';

        return array('caption' => $caption, 'text' => $text);
    }
}

class fanfiction_blocks_form_ui extends e_admin_form_ui
{
    // Custom Method/Function
    public function block_variables($curVal, $mode)
    {
        $blocks = eFiction::blocks();

        $block_name = $this->getController()->getFieldVar('block_name');
		
        $filepath = e_PLUGIN.'efiction/blocks/'.$block_name.'/admin.php';
        $optionpath = e_PLUGIN.'efiction/blocks/'.$block_name.'/admin_options.php';

        //actual value
        if (!empty($curVal)) {
            $value = unserialize($curVal); //use php way
        }
 
        switch ($mode) {
            case 'read': // List Page
                return $curVal;
            break;

            case 'write': // Edit Page

                if ((file_exists($filepath))) {
                    require_once $filepath;

                    $text = $output;
                }

                if ((file_exists($optionpath))) {
                    require_once $optionpath;
                    $this->custom_fields = $options;
                    $options = $this->getFields('block_variables', $value);
                    $text .= $options;
                }

                return $text;

            break;

            case 'filter':
                return null;
            break;

            case 'batch':
                return null;
            break;
        }

        $value = array();

        return null;
    }

    public function getFields($name = '', $value = array())
    {
        if ($name == '') {
            return '';
        }
        $textremove = '';

        //single fields, mainly headers
        $settings = $this->custom_fields;

        if ($settings['fields'] > 0) {
            $nameitem = 'block_variables';
            foreach ($settings['fields'] as $fieldkey => $field) {
                $text .= "<tr><td width='200'>".$field['title'].': </td><td>';
                $text .= $this->renderElement($nameitem.'['.$fieldkey.']', $value[$fieldkey], $field);
                $text .= '</td></tr>';
            }
        } else {
        }
        return $text ;
    }
}

new efiction_adminArea();

require_once e_ADMIN.'auth.php';
e107::getAdminUI()->runPage();

require_once e_ADMIN.'footer.php';
exit;

/*
for later when serialize is solved

$this->custom_fields = $options;
$text = $this->getFields('block_variables', $value);


*/
