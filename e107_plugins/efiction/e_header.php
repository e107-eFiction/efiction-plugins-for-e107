<?php

global $skindir, $skinfolder, $displayform;
 

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
		if(e_CURRENT_PLUGIN === "efiction") {
            e107::js("url", _BASEDIR."includes/javascript.js", "jquery" );
        } 
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
        
        define("e_IFRAME", true);
        
        $inline_code = "if (window.print) {
                      window.print() ;  
                  } else {
                      var WebBrowser = '<OBJECT ID=\"WebBrowser1\" WIDTH=0 HEIGHT=0 CLASSID=\"CLSID:8856F961-340A-11D0-A96B-00C04FD705A2\"></OBJECT>';
                  document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
                      WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box    WebBrowser1.outerHTML = \"\";  
                  }";
        e107::js("inline", $inline_code) ;          
	}
	else {
		
		e107::css("inline", $inline_css) ;
	}	
    if(!empty($_GET['action']) && $_GET['action'] == "yesletter") { 
       define("e_IFRAME", true);
    }
 
 	
}
 