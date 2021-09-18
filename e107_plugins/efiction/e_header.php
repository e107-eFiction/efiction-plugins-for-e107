<?php

global $skindir, $skinfolder;
 

if(deftrue('USER_AREA') && (e_PAGE != "menus.php") )    // prevents inclusion of JS/CSS/meta in the admin area.
{

    /* CAPTCHA REPLACEMENT *****************************************************/
    $newcaptcha = efiction_settings::get_single_setting('captcha');  
    
    if($newcaptcha && extension_loaded('gd'))
    {
    	define('USE_IMAGECODE', TRUE);
    }
    else
    {
    	define('USE_IMAGECODE', FALSE);
    }

  
    /* DISPLAY LOOK ************************************************************/
    $displaycolumns = efiction_settings::get_single_setting('displaycolumns');  
    if(!$displaycolumns) $displaycolumns = 1;  //this is pref, fix me
    $colwidth = floor(100/$displaycolumns);
 
	$inline_css = "
		#columncontainer { margin: 1em auto; width: auto; padding: 5%;}
		#browseblock, #memberblock { width: 100%; padding: 0; margin: 0; float: left; border: 0px solid transparent; }
		.column { float: left; width: ".($colwidth - 1)."%; }
		html>body .column { width: $colwidth%; }
		.cleaner { clear: both; height: 1px; font-size: 1px; margin: 0; padding: 0; background: transparent; }
		#settingsform { margin: auto; padding: 0; border: none;  }
		#settingsform form { width: 100%; margin: 0 10%; }
		#settingsform label { float: left; display: block; width: 30%; text-align: right; padding-right: 10px; clear: left; }
		#settingsform div { clear: both;}
		#settingsform .fieldset SPAN { float: left; display: block; width: 30%; text-align: right; padding-right: 10px; clear: left;}
		#settingsform .fieldset LABEL { float: none; width: auto; display: inline; text-align: left; clear: none; }
 
		#settingsform .tinytoggle { text-align: center; }
		#settingsform .tinytoggle LABEL { float: none; display: inline; width: auto; text-align: center; padding: 0; clear: none; }
		#settingsform #submitdiv { text-align: center; width: 100%;clear: both; height: 3em; }
		#settingsform #submitdiv #submit { position: absolute; z-index: 10001; margin: 1em; }
		a.pophelp{
			position: relative;  
			vertical-align: super;
		}
		
		a.pophelp:hover{z-index:100; border: none; text-decoration: none;}
		
		a.pophelp span{display: none; position: absolute; top: -25em; left: 20em; }
		
		a.pophelp:hover span{  
			display:block;
			position: absolute;
			top: -3em; left: 8em; width: 225px;
			border:1px solid #000;
			background-color:#CCC; color:#000;
			text-decoration: none;
			text-align: left;
			padding: 5px;
			font-weight: normal;
			visibility: visible;
		}
		.required { color: red; }
		.shim {
			position: absolute;
			display: none;
			height: 0;
			width:0;
			margin: 0;
			padding: 0;
			z-index: 100;
		}
		
		.ajaxOptList {
			background: #CCC;
			border: 1px solid #000;
			margin: 0;
			position: absolute;
			padding: 0;
			z-index: 1000;
			text-align: left;
		}
		.ajaxListOptOver {
			padding: 4px;
			background: #CCC;
			margin: 0;
		}
		.ajaxListOpt {
			background: #EEE;
			padding: 4px;
			margin: 0;
		}
		.multiSelect {width: 300px;}";

	if(!isset($_GET['action']) || $_GET['action'] != "printable") 
	{
		e107::js("url", _BASEDIR."includes/javascript.js", "jquery" ); 
	}

	if(isset($displayform) && $displayform == 1) 
	{
		e107::js('url',  _BASEDIR."includes/userselect.js" , 'jquery' );
		e107::js('url',  _BASEDIR."includes/xmlhttp.js" , 'jquery' );
		$inlinecode = "
			lang = new Array( );
		
		lang['Back2Cats'] = '"._BACK2CATS."';
		lang['ChooseCat'] = '"._CHOOSECAT."';
		lang['Categories'] = '"._CATEGORIES."';
		lang['Characters'] = '"._CHARACTERS."';
		lang['MoveTop'] = '"._MOVETOP."';
		lang['TopLevel'] = '"._TOPLEVEL."';
		lang['CatLocked'] = '"._CATLOCKED."';
		basedir = '"._BASEDIR."';
		
		categories = new Array( );
		characters = new Array( );
		\n";		
		e107::js('inline', $inlinecode); 
	}

	if(!empty($_GET['action']) && $_GET['action'] == "printable") { 
		if(file_exists("$skindir/printable.css")) e107::css("efiction", "$skinfolder/printable.css");
		else e107::css("efiction", "default_tpls/printable.css");
	}
	else {
		
		e107::css("inline", $inline_css) ;
	}	
 	
}
 