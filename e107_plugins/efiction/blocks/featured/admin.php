<?php
if (!defined('e107_INIT')) {
    exit;
}

$block_key = 'featured';
include _BASEDIR.'blocks/'.$blocks[$block_key]['file'];

if (isset($_POST['submit'])) {
    if ($_POST['tpl']) {
        $blocks['featured']['tpl'] = 1;
    } else {
        unset($blocks['featured']['tpl']);
    }
    if ($_POST['allowtags']) {
        $blocks['featured']['allowtags'] = 1;
    } else {
        unset($blocks['featured']['allowtags']);
    }
    if ($_POST['sumlength'] && isNumber($_POST['sumlength'])) {
        $blocks['featured']['sumlength'] = $_POST['sumlength'];
    } else {
        unset($blocks['featured']['sumlength']);
    }
    efiction_blocks::save_blocks($blocks);
    $output .= "<div style='text-align: center;'>"._ACTIONSUCCESSFUL.'</div>';
    unset($admin);
	
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
