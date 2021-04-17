<?php
// ----------------------------------------------------------------------
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

$current = 'contactus';

// Include some files for page setup and core functions
include 'header.php';
require_once HEADERF;

$sec_image = e107::getSecureImg();
    //make a new TemplatePower object
if (file_exists("$skindir/default.tpl")) {
    $tpl = new TemplatePower("$skindir/default.tpl");
} else {
    $tpl = new TemplatePower(_BASEDIR.'default_tpls/default.tpl');
}

include 'includes/pagesetup.php';

$caption = _CONTACTUS ;
$tp = e107::getParser();

if (isset($_POST['submit'])) {
	if (USE_IMAGECODE && isset($_POST['rand_num']) && (e107::getSecureImg()->invalidCode($_POST['rand_num'], $_POST['code_verify']))) {
		$output .= write_error(_CAPTCHAFAIL);
	} else {
    
		$sender = check_email($_POST['email_send']);
		$subject = $tp->toEmail($_POST['subject'], true, 'RAWTEXT');
		$body = nl2br($tp->toEmail($_POST['email'], true, 'RAWTEXT'));

        $send_to = SITEADMINEMAIL;
		$send_to_name = ADMIN;
                
        $eml = array(
				'subject'      => $subject,
				'sender_name'  => $sender_name,
				'body'         => $body,
				'replyto'      => $sender,
				'replytonames' => $sender_name,
				'template'     => 'default'
		);
            
        $message = e107::getEmail()->sendEmail($sender, $send_to_name, $eml) ? _EMAILSENT : _EMAILFAILED;
        
	//	include 'includes/emailer.php';
	//	$result = sendemail($sitename, $siteemail, $_POST['email'], $_POST['email'], (!empty($_POST['reportpage']) ? _REPORT.': ' : '').descript(strip_tags($_POST['subject'])), format_story(descript($_POST['comments'])).(!empty($_POST['reportpage']) ? "<br /><br /><a href='$url/".$_POST['reportpage']."'>$url/".$_POST['reportpage'].'</a>' : '').(isMEMBER ? sprintf(_SITESIG2, "<a href='".$url.'/viewuser.php?uid='.USERUID."'>".USERPENNAME.'</a>') : _SITESIG), 'html');
	//	if ($result) {
	//		$output .= write_message(_EMAILSENT);
	//	} else {
	//		$output .= write_error(_EMAILFAILED);
	//	}
        
        e107::getRender()->tablerender('', "<div class='alert alert-success'>" . $message . "</div>");
	}
} else {
	$output .= "<form method='POST' enctype='multipart/form-data' action='report.php'>";

	$val = array();
	$options = array();

	$val['email'] = !empty($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
	$val['comments'] = !empty($_POST['comments']) ? e107::getParser()->toDB($_POST['comments']) : '';
	$val['subject'] = ($_POST['subject']) ? filter_var($_POST['subject'], FILTER_SANITIZE_STRING) : '';

	$userEmail = deftrue('USEREMAIL');

	if (!empty($userEmail)) {
		var_dump(USEREMAIL);
		$options['readonly'] = true;  // don't allow change from a verified email address.
	}
	$val['email'] = !empty($val['email']) ? e107::getParser()->filter($val['email'], 'email') : USEREMAIL;

	$options['required'] = 'required';

	$output .= "<div class='control-group form-group'><label for='email'>"._YOUREMAIL.'</label>
						'.e107::getForm()->email('email', $val['email'], 200, $options).'
				</div>';

	if (!$action) {  //original contact form, it is not used
		$options = array('size' => 30);
		$options['required'] = 1;
		$options['title'] = _SUBJECT;
		$output .= "<div class='control-group form-group'><label for='subject'>"._SUBJECT.'</label>
					'.e107::getForm()->text('subject', $val['subject'], 100, $options).'
			</div>';
	} elseif ($action == 'report') {
		$options = array(_RULESVIOLATION, _BUGREPORT, _MISSING);
		$output .= "<div class='control-group form-group'><label for='subject'>"._REPORT.'</label>
						'.e107::getForm()->select('subject', $options, $curVal, $opts, true).'
			</div>';
	}
	$options = array('size' => 'block-level');

	$options['title'] = _COMMENTS;

	$options['noresize'] = 'true';
	$options['size'] = 'block-level';
	$output .= "<div class='control-group form-group'><label for='comments'>"._COMMENTS.'</label>
						'.e107::getForm()->textarea('comments', '', 5, 80, $options, true).'
				</div>';

	$output .= "<input type='hidden' name='reportpage' value='".descript($_GET['url'])."'> ";

	if (!USERUID && USE_IMAGECODE) {
		//one table field to be able to use recaptcha
		$output .= "<div class='control-group form-group'><label for='code_verify'>".e107::getSecureImg()->renderLabel().'</label>';
		$output .= e107::getSecureImg()->renderimage();
		$output .= e107::getSecureImg()->renderInput().'</div>';
	}
	$output .= " <div style='text-align: center;'><INPUT name='submit' class='button btn btn-primary' type='submit' value='"._SUBMIT."'></div></form>";
}

 $tpl->assign('output', $output);
 $output = $tpl->getOutputContent();
 $output = e107::getParser()->parseTemplate($output, true);
 e107::getRender()->tablerender($caption, $output, $current);
dbclose();
require_once FOOTERF;
