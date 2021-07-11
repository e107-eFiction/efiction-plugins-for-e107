<?php
if (!defined('e107_INIT')) { exit; }

$block_key = 'recent';
include _BASEDIR.'blocks/'.$blocks[$block_key]['file'];
 
	if(isset($_POST['submit'])) {
		if(!empty($_POST['tpl'])) $blocks['recent']['tpl'] = 1;
		else unset($blocks['recent']['tpl']);
		if(!empty($_POST['allowtags'])) $blocks['recent']['allowtags'] = 1;
		else unset($blocks['recent']['allowtags']);
		if(!empty($_POST['sumlength']) && isNumber($_POST['sumlength'])) $blocks['recent']['sumlength'] = $_POST['sumlength'];
		else unset($blocks['recent']['sumlength']);
		if(!empty($_POST['num']) && isNumber($_POST['num'])) $blocks['recent']['num'] = $_POST['num'];
		else $blocks['recent']['num'] = 1;
		$output .= "<div style='text-align: center;'>"._ACTIONSUCCESSFUL."</div>";
		efiction_blocks::save_blocks( $blocks );
 
} else {
    $output .= "<div style='text-align: center;'><span class='h4 text-primary'>"._CURRENT.' '.LAN_PREVIEW.':</span><br /><hr class="preview" > '.$content.'<hr class="preview" ></div>';

    $text = '';
    $frm = e107::getForm();
    $optionpath = e_PLUGIN.'efiction/blocks/'.$block_key.'/'.$block_key.'_options.php';

    if ((file_exists($optionpath))) {
        require_once $optionpath;
        $settings = $options;
    }
    $output .= '
<form method="POST" enctype="multipart/form-data" action="'.e_SELF.'?action=blocks&amp;admin='.$block_key.'"> 
<table class="tblborder table table-bordered">';
    if ($settings['fields'] > 0) {
        foreach ($settings['fields'] as $fieldkey => $field) {
            $text .= '<tr><td >'.$field['title'].': </td><td>';
            $text .= $frm->renderElement($fieldkey, $blocks[$block_key][$fieldkey], $field);
            $text .= '</td></tr>';
        }
    } else {
    }
    $output .= $text ;
    $output .= "</table>
<div class='text-center'><input type=\"submit\" name=\"submit\" class=\"button btn btn-submit btn-primary\" id=\"submit\" value=\""._SUBMIT.'"></div></form></div> ';
}