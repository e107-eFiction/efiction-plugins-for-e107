<?php

// ----------------------------------------------------------------------
// eFiction 3.2
// Copyright (c) 2007 by Tammy Keefer
// Valid HTML 4.01 Transitional
// Based on eFiction 1.1
// Copyright (C) 2003 by Rebecca Smallwood.
// http://efiction.sourceforge.net/
// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------

if (!defined('e107_INIT')) {
    exit;
}
 
$block_key = 'categories';
include _BASEDIR.'blocks/'.$blocks[$block_key]['file'];

if (isset($_POST['submit'])) {
    $blocks['categories']['columns'] = $_POST['columns'];
    $blocks['categories']['template'] = $_POST['template'];
    efiction_blocks::save_blocks($blocks);
    $output .= '<center>'._ACTIONSUCCESSFUL.'</center>';
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
