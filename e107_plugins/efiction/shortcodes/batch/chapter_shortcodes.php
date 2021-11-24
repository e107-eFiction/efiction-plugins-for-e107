<?php

/*
 UNNuke vs Efiction
{STORY_LINK}  = chapter link  {CHAPTER_LINK}
{STORY_TITLE} = {CHAPTER_TITLE}
{AUTHOR_URL} =  author link
{AUTHOR_NAME} 
{STORY_TIME} = {CHAPTER_TIME}
{STORY_CATEGORY_LINK}
{STORY_CATEGORY}
{STORY_COUNTER} 
{STORY_COUNTER_DESC}
{ADMIN_EDIT_LINK}
{ADMIN_EDIT_LINK_DESC}
{ADMIN_DELETE_LINK}
{ADMIN_DELETE_LINK_DESC}
{TOPIC_IMAGE}  = {STORY_IMAGE}
{TOPIC}   = {STORY_TITLE}
{TOPIC_LINK}
{HOMETEXT}  = {CHAPTER_NOTES}
{STORY_NOT_RATED}
{STORY_RATING}
{STORY_RATING_NUM}
{STORY_PRINT}
{COOMENTS_ADD_FIRST_LINK}
{COMMENTS_ADD_FIRST}
{COMMENTS_LINK}
{COMMENTS}
{COMMENTS_COUNT}
{STORY_OPEN}
*/

/* efiction 
{chapternumber} new: {CHAPTER_NUMBER} 

*/


class plugin_efiction_chapter_shortcodes extends e_shortcode
{


        /* {AUTHOR_URL}   */
        public function sc_author_url($parm = null)
    	{
          /* chapter doesn't have coauthors */
          $text = e_HTTP.'viewuser.php?uid='.$this->var['uid'];
          return $text;
        }
        
        /* {AUTHOR_NAME}   */
        public function sc_author_name($parm = null)
    	{
          /* chapter doesn't have coauthors */
          $text = $this->var['penname'];
          return $text;
        }   
     
     
        /* {CHAPTER_NUMBER} */
         public function sc_chapter_number($parm = null)
    	{
          $text = $this->var['inorder'];
          return $text;
        } 
        
               
        
        /* {CHAPTER_LINK}  */
        /* 	$tpl->assign("title", "<a href=\"viewstory.php?sid=$sid&amp;chapter=".$chap['inorder']."\">".$chap['title']."</a>"); */
        public function sc_chapter_link($parm = null)
    	{
            $text = '';
            $sid = $this->var['sid'];
            $text = "viewstory.php?sid=$sid&amp;chapter=".$this->var['inorder'];
  
            return $text;
             
        }    
  
  
        /* {CHAPTER_PRINTICON} */
        /*
            <a href="{STORY_PRINT_LINK}"><img class="printlink" src="images/print.gif" alt="{STORY_PRINT}" title="{STORY_PRINT}"></a>
         	$tpl->assign("printicon", "<a href=\"viewstory.php?action=printable&amp;textsize=$textsize&amp;sid=$sid&amp;chapter=".$chap['inorder']."\" target=\"_blank\"><img src='".(isset($printer) ? $printer :  _BASEDIR."images/print.gif")."' border='0' alt='"._PRINTER."'></a>");
        */
              
        public function sc_chapter_printicon($parm = null)
    	{       
          global $textsize, $printer;
          
          $sid = $this->var['sid'];
          
          $text = "<a href=\"viewstory.php?action=printable&amp;textsize=$textsize&amp;sid=$sid&amp;chapter=".$this->var['inorder']."\" target=\"_blank\">
          <img src='".(isset($printer) ? $printer :  e_PLUGIN_ABS."efiction/images/print.gif")."' border='0' alt='"._PRINTER."'></a>";
          return $text;
        }
           
        
        /* {CHAPTER_NOTES} {notes} */
        public function sc_chapter_notes($parm = null)
    	{
 
            $text = '';
 
                $text = e107::getParser()->toHTML($this->var['notes'], true, 'BODY');
        return $text;
             
        }
             
        
        
        /* {CHAPTER_TITLE} {title}  */
        public function sc_chapter_title($parm = null)
    	{
          $text = $this->var['title'];   
          return $text;     
        }
        
        /* {CHAPTER_TIME} {published} */
        public function sc_chapter_time($parm = null)
    	{
          $dateformat =  efiction_settings::get_single_setting('dateformat');    
            
          $published = date("$dateformat", $this->var['chapter_datestamp']); 
          return $published;       
        }
        
        
    /* {STORY_IMAGE} */
    public function sc_story_image($parm)
    {
             
            $category_icon = $this->var['topicimage'];  
            if($category_icon != '' ) {
                $settings =  array('w'=> 0, 'h'=>0);
             
        		$src =  e107::getParser()->replaceConstants($category_icon, 'full');		
                $icon = e107::getParser()->toImage($src, $settings); 
            }
            else {
               $sitetheme = e107::getPref('sitetheme');
               $path = e_THEME_ABS.$sitetheme.'/' ;
               $src = $path."images/book-magic.jpg";
               $icon = e107::getParser()->parseTemplate($src, true);  
            }      	 
            return $src; 
    }
    
            /* {STORY_TITLE} {title}  */
        public function sc_story_title($parm = null)
    	{
          $text = $this->var['topicname'];   
          return $text;     
        }
        
        
               /* {STORY_STORYNOTES} {storynotes} */
        public function sc_story_storynotes($parm = null)
    	{
            $text = '';
            if($this->var['inorder'] == 1 && !empty($this->var['storynotes'])) 
            {
                $text = e107::getParser()->toHTML($this->var['storynotes'], true, 'BODY');
            }
            return $text;
        }     
 
   
          /* {STORY_SUMMARY} {summary} */
        // ex. {STORY_SUMMARY: limit=100}
        // ex. {STORY_SUMMARY: limit=full}
        public function sc_story_summary($parm = null)
    	{
            $stories = $this->var;
             
            $text = e107::getParser()->toHTML($this->var['summary'], true, 'BODY');
 
            $limit = ($stories['sumlength'] > 0 ? $stories['sumlength'] : 75);  
            if (!empty($parm['limit'])) {
                $limit = $parm['limit'];
            }
            if ($limit == 'full') {
                return $text;
            } else {
                // $text = e107::getParser()->truncate($text, $limit); see issue https://github.com/e107inc/e107/issues/4480 
                $text = efiction_core::truncate_text($text, $limit); //FIX THIS
                return $text;
            }
        }
}