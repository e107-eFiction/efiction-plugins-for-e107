<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

require_once("admin_leftmenu.php");
				
class admin_settings_ui extends e_admin_ui
{
			
 
		// optional - a custom page.  
		public function dasboardPage()
		{
			$ns = e107::getRender();
 
    $vals['settings']['link'] = e_HTTP."admin.php?action=settings&amp;sect=main";
    $vals['settings']['title'] = LAN_EFICTION_MAINSETTINGS;
    $vals['settings']['caption']  = LAN_EFICTION_MAINSETTINGS;
    $vals['settings']['perms'] = 0;
    $vals['settings']['icon_32'] = "<i class='S32 e-prefs-32'></i>";
    
    $vals['submissions']['link'] = e_HTTP."admin.php?action=settings&amp;sect=submissions";
    $vals['submissions']['title'] = LAN_EFICTION_SUBMISSIONSETTINGS;
    $vals['submissions']['caption']  = LAN_EFICTION_SUBMISSIONSETTINGS;
    $vals['submissions']['perms'] = 0;
    $vals['submissions']['icon_32'] = "<i class='S32 e-frontpage-32'></i>";  
    
    $vals['sitesettings']['link'] = e_HTTP."admin.php?action=settings&amp;sect=sitesetting";
    $vals['sitesettings']['title'] = LAN_EFICTION_SITESETTINGS;
    $vals['sitesettings']['caption']  = LAN_EFICTION_SITESETTINGS;
    $vals['sitesettings']['perms'] = 0;
    $vals['sitesettings']['icon_32'] = "<i class='S32 e-frontpage-32'></i>";   
    
    $vals['display']['link'] = e_HTTP."admin.php?action=settings&amp;sect=display";
    $vals['display']['title'] = LAN_EFICTION_DISPLAYSETTINGS;
    $vals['display']['caption']  = LAN_EFICTION_DISPLAYSETTINGS;
    $vals['display']['perms'] = 0;
    $vals['display']['icon_32'] = "<i class='S32 e-frontpage-32'></i>";    
    
    $vals['reviews']['link'] = e_HTTP."admin.php?action=settings&amp;sect=reviews";
    $vals['reviews']['title'] = LAN_EFICTION_SITESETTINGS;
    $vals['reviews']['caption']  = LAN_EFICTION_SITESETTINGS;
    $vals['reviews']['perms'] = 0;
    $vals['reviews']['icon_32'] = "<i class='fas fa-cogs fa-2x'></i>";    
    
    $vals['useropts']['link'] = e_HTTP."admin.php?action=settings&amp;sect=useropts";
    $vals['useropts']['title'] = LAN_EFICTION_REVIEWSETTINGS;
    $vals['useropts']['caption']  = LAN_EFICTION_REVIEWSETTINGS;
    $vals['useropts']['perms'] = 0;
    $vals['useropts']['icon_32'] = "<i class='S32 e-users-32'></i>";  
    
    $vals['email']['link'] = e_HTTP."admin.php?action=settings&amp;sect=email";
    $vals['email']['title'] = LAN_EFICTION_USERSETTINGS;
    $vals['email']['caption']  = LAN_EFICTION_USERSETTINGS;
    $vals['email']['perms'] = 0;
    $vals['email']['icon_32'] = "<i class='S32 e-mail-32'></i>";  

    $vals['censor']['link'] = e_HTTP."admin.php?action=censor";
    $vals['censor']['title'] = LAN_EFICTION_CENSOR;
    $vals['censor']['caption']  = LAN_EFICTION_CENSOR;
    $vals['censor']['perms'] = 0;
    $vals['censor']['icon_32'] = "<i class='S32 e-banlist-32'></i>";    
    
    $vals['copyright']['link'] = e_PLUGIN."/efiction/admin/admin_messages.php?mode=messages&action=edit&id=2";
    $vals['copyright']['title'] = LAN_EFICTION_COPYRIGHT;
    $vals['copyright']['caption']  = LAN_EFICTION_COPYRIGHT;
    $vals['copyright']['perms'] = 0;
    $vals['copyright']['icon_32'] = "<i class='S32 e-frontpage-32'></i>"; 
    
    $vals['printercopyright']['link'] = e_PLUGIN."/efiction/admin/admin_messages.php?mode=messages&action=edit&id=5";
    $vals['printercopyright']['title'] = LAN_EFICTION_PRINTERCOPYRIGHT;
    $vals['printercopyright']['caption']  = LAN_EFICTION_PRINTERCOPYRIGHT;
    $vals['printercopyright']['perms'] = 0;
    $vals['printercopyright']['icon_32'] = "<i class='S32 e-frontpage-32'></i>";   
    
    $vals['tinyMCE']['link'] = e_PLUGIN."/efiction/admin/admin_messages.php?mode=messages&action=edit&id=10";
    $vals['tinyMCE']['title'] = LAN_EFICTION_TINYMCE;
    $vals['tinyMCE']['caption']  = LAN_EFICTION_TINYMCE;
    $vals['tinyMCE']['perms'] = 0;
    $vals['tinyMCE']['icon_32'] = "<i class='S32 e-frontpage-32'></i>";
    
    $vals['nothankyou']['link'] = e_PLUGIN."/efiction/admin/admin_messages.php?mode=messages&action=edit&id=4";
    $vals['nothankyou']['title'] = LAN_EFICTION_NOTHANKYOU;
    $vals['nothankyou']['caption']  = LAN_EFICTION_NOTHANKYOU;
    $vals['nothankyou']['perms'] = 0;
    $vals['nothankyou']['icon_32'] = "<i class='S32 e-notify-32'></i>"; 
    
    $vals['thankyou']['link'] = e_PLUGIN."/efiction/admin/admin_messages.php?mode=messages&action=edit&id=7";
    $vals['thankyou']['title'] = LAN_EFICTION_THANKYOU;
    $vals['thankyou']['caption']  = LAN_EFICTION_THANKYOU;
    $vals['thankyou']['perms'] = 0;
    $vals['thankyou']['icon_32'] = "<i class='S32 e-news-32'></i>"; 
     
      
    foreach($vals AS $val) {
            $tmp = e107::getNav()->renderAdminButton($val['link'], $val['title'], $val['caption'], $val['perms'], $val['icon_32'], "div") ;
            $mainPanel .= $tmp;
					
    }
 
			return $mainPanel  ; 
			
		}
 
		
        
     /**
	 * Get Plugin Links - rewritten for v2.1.5
	 * @param string $iconSize
	 * @param string $linkStyle standard = new in v2.1.5 | array | adminb
	 * @return array|string
	 */
	function pluginLinks($iconSize = E_16_PLUGMANAGER, $linkStyle = 'adminb')
	{
        $pluginLinks =   e107::getNav()->pluginLinks(E_16_PLUGMANAGER, "array") ; 
 
 
        //$unnuke_plugins = array('p-unnuke_series', 'p-unnuke_topics','p-unnuke_web_links', 'p-unnuke_groups','p-unnuke_images', 'p-efiction_authors',);
        
        $unnuke_plugins = array('p-unnuke_series', 'p-unnuke_topics','p-unnuke_web_links', 'p-unnuke_groups','p-unnuke_images', 'p-efiction_authors',);
        
        foreach($pluginLinks as $k=>$v)
		{
			if(in_array($k,$unnuke_plugins))
			{
				$data[$k] = $v;
			}
		}
        
        return $data; 
    }
    	
}
				


class admin_settings_form_ui extends e_admin_form_ui
{

}		
		
new efiction_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;
