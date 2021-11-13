<?php 
 
if (!defined('_BASEDIR')) define('_BASEDIR', e_PLUGIN.'efiction/');
if (!defined('TABLEPREFIX')) define('TABLEPREFIX', MPREFIX);
if (!defined('SITEKEY'))  define('SITEKEY', $e107->site_path);
 
require_once(_BASEDIR."includes/dbfunctions.php");
 
if(e_ADMIN_AREA === true)  {}  //USER_AREA is not defined
else { 
     
  e107::lan('efiction');
  e107::lan('efiction', true);
   /* LOAD CLASSES */
  e107::getSingleton('efiction_core', e_PLUGIN.'efiction/classes/efiction.class.php');
  e107::getSingleton('efiction_blocks', e_PLUGIN.'efiction/classes/blocks.class.php');
  e107::getSingleton('efiction_pagelinks', e_PLUGIN.'efiction/classes/pagelinks.class.php');  
  e107::getSingleton('efiction_settings', e_PLUGIN.'efiction/classes/settings.class.php');
  e107::getSingleton('efiction_authors', e_PLUGIN.'efiction/classes/authors.class.php');  
  e107::getSingleton('efiction_panels', e_PLUGIN.'efiction/classes/panels.class.php'); 
  e107::getSingleton('efiction_categories', e_PLUGIN.'efiction/classes/categories.class.php'); 
  e107::getSingleton('efiction_classes', e_PLUGIN.'efiction/classes/classes.class.php');   
  e107::getSingleton('efiction_ratings', e_PLUGIN.'efiction/classes/ratings.class.php'); 
  e107::getSingleton('efiction_stories', e_PLUGIN.'efiction/classes/stories.class.php'); 
    
  /**************  LOAD EFICTION SETTINGS ***************************************/    
  $settings = efiction_settings::get_settings();
 
  $defaultskin = $settings['skin']; //used in get_session_vars.php
  $skin = $settings['skin']; //used for authorprefs
  
   
  /**************  DETECT SKIN FOLDER       *************************************/
  if(varset($siteskin) && is_dir(_BASEDIR."skins/$siteskin")) { 
  	$skindir = _BASEDIR."skins/$siteskin";
  	$skinfolder = "skins/$siteskin";
  }
  elseif(varset($defaultskin) && is_dir(_BASEDIR."skins/$defaultskin")) {
  	$skindir = _BASEDIR."skins/".$defaultskin;
  	$skinfolder = "skins/".$defaultskin;    
  }
  else { 
  	$skindir = _BASEDIR."default_tpls";
  	$skinfolder = "default_tpls";
  }
   
   

  
 }
 
 