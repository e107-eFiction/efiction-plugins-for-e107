<?php

// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
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

/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 efiction Plugin
 *
 * #######################################
 * #     e107 website system plugin      #
 * #     by Jimako                    	 #
 * #     https://www.e107sk.com          #
 * #######################################
 */

class plugin_efiction_storyform_shortcodes extends e_shortcode
{
    private $admin = false;
    private $uid = 0;

    public function __construct()
    {
        if (getperms('0')) {  //e107 superadmin
            $this->admin = 1;
            $this->uid = isset($_GET['uid']) && isNumber($_GET['uid']) ? $_GET['uid'] : USERUID;
        } elseif (isADMIN && uLEVEL < 4 && isset($_GET['admin'])) {  //efiction adminarea
            $this->admin = 1;
            $this->uid = isset($_GET['uid']) && isNumber($_GET['uid']) ? $_GET['uid'] : USERUID;
        } else {
            $this->admin = 0;
            $this->uid = USERUID;
        }
    }

    /* {STORY_EDIT_CATEGORY} */
    public function sc_story_edit_category()
    {
        $catid = $this->var['catid'];
        $multiplecats = efiction_settings::get_single_setting('multiplecats');
        $output = '';
        if (!$multiplecats) {
            $text = '<input type="hidden" name="catid" id="catid" value="1">';
        } else {
            include _BASEDIR.'includes/categories.php';
            $text = $output;
        }
        return $text;
    }

    /* {STORY_EDIT_AUTHOR} */
    public function sc_story_edit_author()
    {
        if ($this->admin) {
            $authors = efiction_authors::get_authors_list();
            $text = e107::getForm()->select('uid', $authors, $this->var['uid'], array('required' => 1, 'data-width'=>'100%', 'class'=>'form-control select2-single' ), _AUTHOR);
        } else {
            return '';
        }

        return $text;
    }

    /* {STORY_EDIT_COAUTHORS} */
    public function sc_story_edit_coauthors()
    {
        $coauthallowed = efiction_settings::get_single_setting('coauthallowed');

        if ($coauthallowed) {
            $authors = efiction_authors::get_authors_list();  //all available authors
            $text = e107::getForm()->select('coauthors', $authors, $this->var['coauthors'], array('data-width'=>'100%', 'class' => 'form-control select2-multiple', 'multiple' => 1), true);
        } else {
            return '';
        }

        return $text;
    }

    /* {STORY_EDIT_TITLE} */
    public function sc_story_edit_title()
    {
        $title = $this->var['title'];
        $text = e107::getForm()->text('title', htmlentities($title), 200, array('size' => 'large', 'required' => 1, 'class'=>'form-control', 'id' => 'storytitle'));
        return $text;
    }

    /* {STORY_EDIT_SUMMARY} */
    public function sc_story_edit_summary()
    {
        $tinyMCE = efiction_settings::get_single_setting('tinyMCE');  
         $text = e107::getForm()->textarea('summary', $this->var['summary'], '3', '58', array('class' => 'useeditor form-control', 'required' => 1, ));
        return $text;
    }

    /* {STORY_EDIT_STORYNOTES} */
    public function sc_story_edit_storynotes()
    {
        $text = e107::getForm()->textarea('storynotes', $this->var['storynotes'], '3', '58', array('class' => 'form-control',  ));
        return $text;
    }
 

    /* STORY_EDIT_CODEBLOCK */
    public function sc_story_edit_codeblock($parm)
    {
        if ($parm == 'storyform_start') {
            $stories = $this->var;
            $codequery = "SELECT * FROM #fanfiction_codeblocks WHERE code_type = 'storyform_start'";
            $codes = e107::getDb()->retrieve($codequery, true);
            foreach ($codes as $code) {
                //example:  include(_BASEDIR."modules/translations/admin/storyform.php"
                eval($code['code_text']);
            }
            $text = $output;
            $output = '';
            return $text;
        } elseif ($parm == 'storyform') {
            $stories = $this->var;
            $codequery = "SELECT * FROM #fanfiction_codeblocks WHERE code_type = 'storyform'";
            $codes = e107::getDb()->retrieve($codequery, true);
            foreach ($codes as $code) {
                //example:  include(_BASEDIR."modules/translations/admin/storyform.php"
                eval($code['code_text']);
            }
            $text = $output;
            $output = '';
            return $text;
        }
    }

    /* {STORY_EDIT_RATING} */
    public function sc_story_edit_rating()
    {
        $ratings = efiction::get_ratings_list();
        $text = '<label for=""rid">{LAN=_RATING}: </label><br>';
        $text .= e107::getForm()->select('rid', $ratings, $this->var['rid'], array('required' => 1, 'data-width'=>'100%', 'class'=>'form-control select2-single'), _RATING);

        return $text;
    }

    /* {STORY_EDIT_COMPLETE} */
    public function sc_story_edit_complete()
    {
        $text = '<label for=""complete">{LAN=_COMPLETE}: </label><br>';
        $text .= e107::getForm()->radio_switch('complete', $this->var['complete'], _YES, _NO);

        return $text;
    }

    /* {STORY_EDIT_VALIDATED} */
    public function sc_story_edit_validated()
    {
        if (isADMIN && uLEVEL < 4) {
            $values = array(1 => _CHAPTER, 2 => _STORY,  0 => _NO, );
            $text = '<label for="validated">'._VALIDATED.': </label><br>';
            $text .= e107::getForm()->radio('validated', $values, $this->var['validated']);
            return $text;
        }

        return '';
    }

    /* {STORY_EDIT_FEATURED} */
    public function sc_story_edit_featured()
    {
        if (isADMIN && uLEVEL < 4) {
            $values = array(1 => _ACTIVE, 2 => _RETIRED,  0 => _NO, );
            $text = '<label for="feature">'._FEATURED.': </label><br>';
            $text .= e107::getForm()->radio('feature', $values, $this->var['feature']);

            return $text;
        }
        return '';
    }

    /* {STORY_EDIT_CHARACTERS} */
    public function sc_story_edit_characters()
    {
        $catid = $this->var['catid'];

        $query = 'SELECT charname, catid, charid FROM #fanfiction_characters ORDER BY charname';
        $result4 = e107::getDb()->retrieve($query, true);
        foreach ($result4 as $charresults) {
            if ((is_array($catid) && in_array($charresults['catid'], $catid)) || $charresults['catid'] == -1) {
                $characters[$charresults['charid']] = stripslashes($charresults['charname']);
            }
        }
        $options = array('title' => _CHARACTERS, 'inline' => true,  'useKeyValues' => 1);
        $text = e107::getForm()->checkboxes('charid', $characters, $this->var['charid'], $options);

        return $text;
    }

    /* {STORY_EDIT_CLASSES} */
    public function sc_story_edit_classes()
    {
        $classrows = e107::getDb()->retrieve('SELECT * FROM #fanfiction_classtypes ORDER BY classtype_name', true);
        $ret .= '<style> #admin-ui-edit .checkbox-inline {min-width: 300px;}
		#characters-container .checkbox-inline  {margin-left: 20px!important; } 
		#catid-container .checkbox-inline  {margin-left: 20px!important; }  
		#classes-container .checkbox-inline  {margin-left: 20px!important; } 
		</style>';
        foreach ($classrows as $type) {
            $ret .= "<div class='form-group'><label for=\"class_".$type['classtype_id']."\"><b>$type[classtype_title]:</b></label>:<br>";
            $result2 = e107::getDb()->retrieve("SELECT * FROM #fanfiction_classes WHERE class_type = '$type[classtype_id]' ORDER BY class_name", true);
            $values = array();
            foreach ($result2 as $row) {
                $values[$row['class_id']] = $row['class_name'] ;
            }
            $options['useKeyValues'] = true;
            $options['inline'] = true;
            $ret .= e107::getForm()->checkboxes('classes', $values, $this->var['classes'], $options);
            $ret .= '</div>';
        }
        return $ret;
    }

    /* {STORY_EDIT_CHAPTERS_LIST} */
    public function sc_story_edit_chapters_list()
    {
        $sid = $this->var['sid'];
        if (!$sid) {
            return '';
        }

        $template = e107::getTemplate('efiction', 'storyform', 'chapter_list');
        $sc2 = e107::getScParser()->getScObject('chapter_shortcodes', 'efiction', false);

        $tmp = $this->var['chapters'];

        $text = $template['start'];

        $this->chapters = count($this->var['chapters']);
        foreach ($tmp as $chapter) {
            $chapter['chapters'] = $this->chapters;
            $sc2->setVars($chapter);
            $text .= $output = e107::getParser()->parseTemplate($template['item'], true, $sc2);
        }
        $text .= $template['end'];

        return $text;
    }

    /* {STORY_BUTTON_PREVIEW} */
    public function sc_story_button_preview()
    {
        $text = '<input type="submit" class="button btn btn-secondary" value="'._PREVIEW.'" name="submit">';
        return $text;
    }

    /* {STORY_BUTTON_SAVE} */
    public function sc_story_button_save()
    {
    
        switch($this->var['action']) {
          
          case "editstory":
            $text = '<input type="submit" class="button btn btn-success" value="'._EDITSTORY.'" name="submit">';
            break;
          case "newstory":
              $text = '<input type="submit" class="button btn btn-success" value="'._ADDSTORY.'" name="submit">';
              break;   
          case "editchapter":
            $text = '<input type="submit" class="button btn btn-success" value="'._EDITCHAPTER.'" name="submit">';
            break;
          case "newchapter":
              $text = '<input type="submit" class="button btn btn-success" value="'.LAN_SAVE.'" name="submit">';
              break;                       
        }
         
        return $text;
    }

    /* {STORY_BUTTON_ADD_CHAPTER} */
    public function sc_story_button_add_chapter()
    {
		if($this->var['action'] == "newstory") return '';

        $sid = $this->var['sid'];
        $storyuid = $this->var['uid'];
        $chapters = count($this->var['chapters']);
        $text = "<a class=\"button btn btn-primary\" href=\"stories.php?action=newchapter&amp;sid=$sid&amp;inorder=$chapters".($this->admin ? '&amp;admin=1&amp;uid='.$storyuid : '').'">'._ADDNEWCHAPTER.'</a>';
        return $text;
    }

    /* {STORY_EDIT_STORYTEXT} == chapter text in fact */
    public function sc_story_edit_storytext()
    {
        $tinyMCE = efiction_settings::get_single_setting('tinyMCE'); $tinyMCE = false;
        if ($tinyMCE) {
            $text = e107::getForm()->bbarea('storytext', $this->var['storytext'], null, array('required' => true)); 
        } else {
            $text = e107::getForm()->textarea('storytext', $this->var['storytext'], '6', '58', array('class' => 'col-md-12', 'required' => true));
        }

        return $text;
    }
    
    /* {STORY_EDIT_CHAPTERTITLE}  */
    public function sc_story_edit_chaptertitle()
    {
        $inorder = $this->var['inorder'];
        $chaptertitle =  $this->var['chaptertitle'];
        $inorder++;    
        
        $default = _CHAPTER.' '.$inorder;
        if ($chaptertitle != '') {
            $default = $chaptertitle;
        }
        
        $chaptertitle = $this->var['chaptertitle'];
        $text = e107::getForm()->text('chaptertitle', htmlentities($default), 200, array('size' => '50', 'required' => 1, 'id' => 'chaptertitle'));
        return $text;
        return $text;
    }   
    
    /* {STORY_EDIT_CHAPTERNOTES} */
    public function sc_story_edit_chapternotes()
    {
        $tinyMCE = efiction_settings::get_single_setting('tinyMCE'); $tinyMCE = false;
        if ($tinyMCE) {
            $text = e107::getForm()->bbarea('endnotes', $this->var['endnotes'] ) ;
        } else {
            $text = e107::getForm()->textarea('endnotes', $this->var['endnotes'], '6', '58', array('class' => 'col-md-12' ));
        }

        return $text;
    }   
 
}
