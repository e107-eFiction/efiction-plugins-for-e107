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

e107::lan('efiction', true, true);

if (!class_exists('efiction_setup')) {
    class efiction_setup
    {
        var $tables = array();
        
        function __construct() {
        
            $this->tables_data = array('fanfiction_settings','fanfiction_panels','fanfiction_pagelinks', 'fanfiction_blocks', 'fanfiction_messages', 'fanfiction_authors', 'fanfiction_stats'
            , 'fanfiction_ratings' );
 
        }
        
 
        
        public function install_pre($var)
        {
           
            
        }
 

		public function fix_user_extended_fields() {

         	$query = "UPDATE `".MPREFIX."user_extended_struct` SET `user_extended_struct_signup` = '1' WHERE `e107_user_extended_struct`.`user_extended_struct_name` = 'plugin_efiction_betareader'";

			e107::getDB()->gen($query); 

			$query = "UPDATE `".MPREFIX."user_extended_struct` SET `user_extended_struct_write` = '250' WHERE `e107_user_extended_struct`.`user_extended_struct_name` = 'plugin_efiction_author_uid'";

			e107::getDB()->gen($query); 

			$query = "UPDATE `".MPREFIX."user_extended_struct` SET `user_extended_struct_write` = '250' WHERE `e107_user_extended_struct`.`user_extended_struct_name` = 'plugin_efiction_level'";
			
			e107::getDB()->gen($query); 

		}


        public function add_default_data($var) {
        
			$pref = e107::pref('core');
			$sitekey = e107::getInstance()->getSitePath();
			define("SITEKEY", $sitekey);

          	foreach($this->tables_data AS $table) {  
                if(e107::getDb()->count($table) == 0)
     			{
					if($table == 'fanfiction_settings')  {
						include(e_PLUGIN."efiction/version.php");
						$insert = array(
							'sitekey'     => SITEKEY,
							'sitename' => $pref['sitename'] ,    //fix this
							'slogan' =>  $pref['sitedescription'] ,	//fix this
							'url'     =>   $pref['siteurl'] ,  //fix this
							'siteemail'       => $pref['siteadminemail'] ,  //or 'replyto_email'
							'tableprefix'   => MPREFIX,
							'skin'  => $pref['sitetheme'] ,  //fix this  
							'hiddenskins' => '' ,
							'language' => $pref['sitelanguage'] ,     // fix this English = en
							'submissionsoff' => 0 ,
							'storiespath' => 'stories' , //not supported
							'store' => 'db' ,
							'autovalidate' => 0 ,
							'coauthallowed' => 0 ,
							'maxwords' => 0 ,
							'minwords' => 0 ,
							'imageupload' => 0 ,
							'imageheight' => 200 ,
							'imagewidth' => 200,
							'roundrobins' =>0 ,
							'allowseries' => 2 ,
							'tinyMCE' =>0 ,
							'allowed_tags' => '<b><i><u><center><hr><p><br /><br><blockquote><ol><ul><li><img><strong><em>',
							'favorites' => 0,
							'multiplecats' =>0,
							'newscomments' =>0 ,
							'logging' =>0 ,
							'maintenance' =>0 ,
							'debug' =>0 ,
							'captcha' =>0 ,
							'dateformat' => 'd/m/y',
							'timeformat' => '- h:i a',
							'recentdays' => '7',
							'displaycolumns'=> '1',
							'itemsperpage' => '25',
							'extendcats' => '0',
							'displayindex' => '0',
							'defaultsort' => '0',
							'displayprofile' => '0',
							'linkstyle' => '0', 
							'linkrange' => '5',
							'reviewsallowed' => '0',
							'ratings' => '0',
							'anonreviews' => '0',
							'revdelete' => '0',
							'rateonly' => '0',
							'pwdsetting' => '0',
							'alertson' => '0',
							'disablepopups' => '0',
							'agestatement' => '0',
							'words' => '',
							'version' => $version,


							'_DUPLICATE_KEY_UPDATE' => 1
							);
						e107::getDB()->insert("fanfiction_settings", $insert);
					} 
					elseif($table == 'fanfiction_panels')  {

						$panellist = array(
							array("submitted","Submissions", "","3","5","0","A"),
							array("newstory","Add New Story","stories.php?action=newstory&admin=1","3","3","0","A"),
							array("addseries","Add New Series","series.php?action=add","3","3","0","A"),
							array("featured","Featured Stories","","3","5","0","A"),
							array("characters","Characters","","2","2","0","A"),
							array("ratings","Ratings","","2","3","0","A"),
							array("members","Members","","2","5","0","A"),
							array("settings","Settings","","1","2","0","A"),
							array("blocks","Blocks","","1","3","0","A"),
							array("censor","Censor","","1","0","1","A"),
							array("admins","Admins","","1","6","0","A"),
							array("classifications","Classifications","","2","4","0","A"),
							array("categories","Categories","","2","1","0","A"),
							array("custpages","Custom Pages","","1","4","0","A"),
							array("validate","Validate Submission","","3","0","1","A"),
							array("yesletter","Validation Letter","","3","0","1","A"),
							array("noletter","Rejection Letter","","3","0","1","A"),
							array("links","Page Links","","1","5","0","A"),
							array("messages","Message Settings","","2","0","1","A"),
							array("logout","Logout","index.php?logout","1","5","0","U"),   //e107
							array("revreceived","Reviews Received","","1","0","1","U"),
							array("editprefs","Edit Preferences","","1","2","0","U"),
							array("lostpassword","Lost Password","fpw.php","0","0","1","U"), //e107
							array("editbio","Edit Bio","usersettings.php","1","1","0","U"),  //e107
							array("register","Register","signup.php","0","0","1","U"), //e107
							array("manageimages","Manage Images","","1","5","0","S"),
							array("revres","Review Response","","1","0","1","U"),
							array("stats","View Your Statistics","","1","3","0","U"),
							array("newstory","Add New Story","stories.php?action=newstory","1","1","0","S"),
							array("newseries","Add New Series","series.php?action=add","1","3","0","S"),
							array("stories","Manage Stories","stories.php?action=viewstories","1","2","0","S"),
							array("series","Manage Series","series.php?action=manage","1","4","0","S"),
							array("reviewsby","Your Reviews","","1","0","1","U"),
							array("storiesby","Stories by {author}","","0","1","0","P"),
							array("seriesby","Series by {author}","","0","2","0","P"),
							array("reviewsby","Reviews by {author}","","0","3","0","P"),
							array("categories","Categories","","0","1","0","B"),
							array("characters","Characters","","0","2","0","B"),
							array("ratings","Ratings","","0","3","0","B"),
							array("titles","Titles","","0","5","0","B"),
							array("class","Classes","","0","0","1","B"),
							array("recent","Most Recent","","0","0","1","B"),
							array("featured","Featured Stories","","0","0","1","B"),
							array("panels","Panels","","1","1","0","A"),
							array("series", "Series", "", "0", "4", "0", "B"),
							array("viewlog", "Action Log", "", "1", "8", "0", "A"),
							array("shortstories","10 Shortest Stories","toplists/default.php","0","6","0","L"), 
							array("longstories","10 Longest Stories","toplists/default.php","0","5","0","L"), 
							array("largeseries","10 Largest Series","toplists/default.php","0","1","0","L"), 
							array("smallseries","10 Smallest Series","toplists/default.php","0","2","0","L"), 
							array("reviewedseries","10 Most Reviewed Series","toplists/default.php","0","4","0","L"), 
							array("prolificauthors","10 Most Prolific Authors","toplists/default.php","0","10","0","L"), 
							array("prolificreviewers","10 Most Prolific Reviewers","toplists/default.php","0","12","0","L"), 
							array("reviewedstories","10 Most Reviewed Stories","toplists/default.php","0","8","0","L"), 
							array("readstories","10 Most Read Stories","toplists/default.php","0","9","0","L"),
							array("manfavs","Manage Favorites","","1","2","0","F"),
							array("favstories","10 Most Favorite Stories","toplists/default.php","0","7","0","L"), 
							array("favauthors","10 Most Favorite Authors","toplists/default.php","0","11","0","L"), 
							array("favseries","10 Most Favorite Series","toplists/default.php","0","3","0","L"), 
							array("favst","Favorite Stories","","0","0","1","F"),
							array("favse","Favorite Series","","0","0","1","F"),
							array("favau","Favorite Authors","","0","0","1","F"),
							array("favst","Favorite Stories","","0","0","1","U"),
							array("favse","Favorite Series","","0","0","1","U"),
							array("favau","Favorite Authors","","0","0","1","U"),
							array("favlist","{author}\'s Favorites","viewuser.php?action=manfavs","0","5","0","F"),
							array("skins", "Skins", "", "3", "6", "0", "A"),
							array("maintenance", "Archive Maintenance", "", "1", "10", "0", "A"),
							array("manual", "Admin Manual", "", "3", "6", "0", "A"),
							array('modules', 'Modules', '', 1, "11", 0, 'A')
						);

						foreach($panellist as $panel) {
						 	$query = "INSERT INTO `#fanfiction_panels` (`panel_name`, `panel_title`, `panel_url`, `panel_level`, `panel_order`, `panel_hidden`, `panel_type`) VALUES ('".$panel[0]."', '".$panel[1]."', '".$panel[2]."', '".$panel[3]."', '".$panel[4]."', '".$panel[5]."', '".$panel[6]."')";

							e107::getDB()->gen($query);
						}
					}
					elseif($table == 'fanfiction_pagelinks') {
						$pagelist = array(
							array("home","Home","index.php","0","0"),
							array("recent","Most Recent","browse.php?type=recent","0","0"),
							array("adminarea","Admin","admin.php","0","2"),
							array("logout","Logout","index.php?logout","0","1"),
							array("featured","Featured Stories","browse.php?type=featured","0","0"),
							array("catslink","Categories","browse.php?type=categories","0","0"),
							array("members","Members","authors.php?action=list","0","0"),
							array("authors","Authors","authors.php?list=authors","0","0"),
							array("help","Help","viewpage.php?page=help","0","0"),
							array("search","Search","searching.php","0","0"),
							array("series","Series","browse.php?type=series","0","0"),
							array("tens","Top Tens","toplists.php","0","0"),
							array("challenges","Challenges","modules/challenges/challenges.php","0","0"),
							array("rules","Rules","viewpage.php?page=rules","0","0"),
							array("tos","Terms of Service","viewpage.php?page=tos","0","0"),
							array("rss","<img src=\'images/xml.gif\' alt=\'RSS\' border=\'0\'>","rss.php","0","0"),
							array("login","Account Info","member.php","0","1"),
							array("titles","Titles","browse.php?type=titles","0","0"),
							array("register","Register","signup.php","0","0"),
							array("lostpassword","Lost Password","fpw.php","0","0"),
							array("browse","Browse","browse.php","0","0"),
							array("charslink", "Characters", "browse.php?type=characters","0","0"),
							array("ratings", "Ratings", "browse.php?type=ratings", "0", "0"),
						);

						foreach($pagelist as $page) {
							$query = "INSERT INTO `#fanfiction_pagelinks` (`link_name`, `link_text`, `link_url`, `link_target`, `link_access`) VALUES ('".$page[0]."', '".$page[1]."', '".$page[2]."', '".$page[3]."', '".$page[4]."')";

						   e107::getDB()->gen($query);
					   }

					}
					elseif($table == 'fanfiction_blocks') {

						$blocklist = array(
							array("categories","Categories","categories/categories.php","1",""),
							array("featured","Featured Stories","featured/featured.php","1",""),
							array("info","Site Info","info/info.php","2",""),
							array("menu","Main Menu","menu/menu.php","1",""),
							array("random","Random Story","random/random.php","2",""),
							array("recent","Most Recent","recent/recent.php","2","a:1:{s:3:\"num\";s:1:\"1\";}"),
							array("skinchange","Skin Change","skinchange/skinchange.php","1","")
                             
						);

						foreach($blocklist as $block) {
							$block_settings = e107::getDB()->escape($block[4]);
							$query = "INSERT INTO `#fanfiction_blocks` (`block_name`, `block_title`, `block_file`, `block_status`, `block_variables`) VALUES('".$block[0]."', '".$block[1]."', '".$block[2]."', '".$block[3]."', '".$block_settings."')";
							e107::getDB()->gen($query);		 
	 	                }
					}
					elseif($table == 'fanfiction_messages') {
						$messageslist = array(
							array(3, 'help', 'Help', "<h3>FAQ</h3><p><strong>I forgot my password!&nbsp; What do I do now?</strong></p><p>To recover a lost password, <a href=\"member.php?action=lostpassword\">click here</a> and enter the e-mail address with which you registered.&nbsp; Your password will be sent to you shortly.</p><p><strong>What kinds of stories are allowed?</strong></p><p>See our <a href=\""._BASEDIR."submission.php\">Submission Rules.</a></p><p><strong>How do I contact the site administrators?</strong></p><p>You can e-mail us via our <a href=\"contact.php\">contact form.</a></p><p><strong>How do I submit stories?</strong></p><p>If you have not already done so, please <a href=\"member.php?action=newaccount\">register for an account</a>. Once you\'ve logged in, click on <a href=\"member.php\">Account Information</a> and choose <a href=\"stories.php?action=newstory\">Add Story</a>.&nbsp; The form presented there will allow you to submit your story.</p><p><strong>What are the ratings used on the site?</strong></p><p>We use the ratings system from <a href=\"http://www.fictionratings.com/\">www.fictionratings.com</a>.</p><p><strong>What are the story classifications?</strong></p><p>Stories are classified by categories, genres, and warnings.</p>"),
							array(4, 'nothankyou', 'Submission Rejection', 'Your recent submission of \"{storytitle} : {chaptertitle}\" to {sitename} did not meet our requirements for submission.  Please review our {rules}.<br /><br />\r\n\r\n{adminname}'),
							array(5, 'printercopyright', '', "<u>Disclaimer:</u> All publicly recognizable characters and settings are the property of their respective owners. The original characters and plot are the property of the author. No money is being made from this work. No copyright infringement is intended."),
							array(6, 'rules', 'Submission Rules', "<p align=\"center\"><strong>Submission Rules</strong></p>\r\n<ol>\r\n  <li>All submissions must be accompanied by a complete disclaimer. If a \r\n  suitable disclaimer is not included, the site administrators reserve the right \r\n  to add a disclaimer.&nbsp; Repeat offenders may be subject to further action \r\n  up to and including removal of stories and account.\r\n<div class=\"tblborder\" style=\"width: 400px; margin: 1em auto;\">\r\n<div style=\"background: #000; color: #FFF; padding: 5px; text-align: center; font-weight: bold;\">Sample Disclaimer</div>\r\n<div class=\"tblborder\" style=\"padding: 5px;\"><span style=\"text-decoration: underline;\">Disclaimer:</span>  All publicly recognizable characters, settings, etc. are the property of their respective owners.  The original characters and plot are the property of the author.&nbsp; \r\n        The author is in no way associated with the owners, creators, or producers of any media franchise.&nbsp;  No copyright infringement is intended.</div>\r\n  </div>\r\n  </li>\r\n  <li>Stories must be submitted to the proper category. &nbsp;If there is an appropriate sub-category, <strong>DO NOT</strong> add your story to the main category.&nbsp; The submission \r\n  form allows you to choose multiple categories for your story, and we worked very hard to add that functionality for you.&nbsp;&nbsp; <u><strong>So please \r\n  do NOT add your story multiple times!</strong></u></li>\r\n  <li>Titles and summaries must be kid friendly.&nbsp; No exceptions.&nbsp; </li>\r\n  <li>&quot;Please read&quot;, &quot;Untitled&quot;, etc. are not acceptable titles or summaries.</li>\r\n  <li>A number of authors have requested that fans refrain from writing fan \r\n  fiction based on their work.&nbsp; Therefore submissions will not be \r\n  accepted based on the works of P.N. Elrod, Raymond Feist, Terry Goodkind, \r\n  Laurell K. Hamilton, Anne McCaffrey, Robin McKinley, Irene Radford, Anne Rice, \r\n  and Nora Roberts/J.D. Robb.&nbsp; </li>\r\n  <li>Actor/actress stories are not permitted...not even if they\'re visiting an \r\n  alternate reality.</li>\r\n  <li>Correct grammar and spelling are expected of all stories submitted to this \r\n  site.&nbsp; The site administrators are not grammar Nazis.&nbsp; However, the \r\n  site administrators reserve the right to request corrections in submissions \r\n  with a multitude of grammar and/or spelling errors.&nbsp; If such a request is \r\n  ignored, the story will be deleted.</li>\r\n  <li>All stories must be rated correctly and have the appropriate warnings.&nbsp; \r\n  All adult rated stories are expected to have warnings.&nbsp; After all, they \r\n  wouldn\'t have that rating if there wasn\'t something to be warned about!&nbsp; The site administrators recognize \r\n  that there is an audience for these stories, but please respect those who do \r\n  not wish to read them by labeling them appropriately.&nbsp;\r\n  <u><strong>Please note: Stories containing adults having sex with minors are strictly forbidden.</strong></u>&nbsp; </li>\r\n  <li>Stories with multiple chapters should be archived as such and <span style=\"font-weight: bold; text-decoration: underline;\">NEVER</span> as \r\n  separate stories.&nbsp; Upload the first chapter of your story, then go to <a href=\"stories.php?action=viewstories\">Manage Stories</a> in \r\nyour account to add additional chapters.  If you have trouble with this, please contact the site administrator or ask a \r\n  friend to help you.</li>\r\n  <li>As much as possible, spoiler warnings are expected on all stories.  For categories with serialized content, such as series of books or television series, \r\n  spoilers are <strong>mandatory</strong> for the current season and/or most recent part.  An appropriate spoiler warning to place in your summary would be: Spoilers for <u>Star Trek II: The Wrath of Khan.</u> \r\n  <strong>DO NOT</strong> do anything like this: <u>Spoilers for the one where Spock dies.</u></li>\r\n</ol>\r\n  <p>Submissions found to be in violation of these rules may be removed and the \r\n  author\'s account suspended at the discretion of the site administrators and/or \r\n  moderators.&nbsp; The site administrators reserve the right to modify these \r\n  rules as needed.</p>"),
							array(7, 'thankyou', '{sitename} Submission Acceptance', "Thanks for your submission."),
							array(8, 'tos', 'Terms of Service', "This is the Terms of Service for your site.  It will be displayed when a new member registers to the site."),
							array(9, 'maintenance', 'Site Maintenance', "<p style=\"text-align: center;\">This site is currently undergoing maintenance.  Please check back soon.  Thank you.</p>")
						);
		

							foreach($messageslist as $message) {
                                $message_text = e107::getDB()->escape($message[3]);
                                $message_text = "[html]".$message_text."[/html]";
								$query = "INSERT INTO `#fanfiction_messages` (`message_id`, `message_name`, `message_title`, `message_text`) VALUES('".$message[0]."', '".$message[1]."', '".$message[2]."', '".$message_text."')";
							 
                                e107::getDB()->gen($query);		 
							}
 

					}
					elseif($table == 'fanfiction_authors') {
           
						//create main ID
						$userdata = e107::user(USERID); //actual user doing installation 

						$insert = array(
							'penname' => $userdata['user_name'], 
							'email' => $userdata['user_email'],  
							'password' => '', //delete 
							'date' => $userdata['user_join'],   
                            'user_id' => USERID,
							'_DUPLICATE_KEY_UPDATE' => 1
						);
                        
						$dbinsertid = e107::getDB()->insert("fanfiction_authors", $insert);
     
						if($dbinsertid)	{
							
							$insert2 = array(
								'uid'    =>  $dbinsertid,
								'level' => 1,  //main admin
								'_DUPLICATE_KEY_UPDATE' => 1
							);
							e107::getDB()->insert("fanfiction_authorprefs", $insert2);
						     
                            $ue = new e107_user_extended;
        	                $ue->user_extended_setvalue(USERID, 'user_plugin_efiction_author_uid', $dbinsertid);
                            $ue->user_extended_setvalue(USERID, 'user_plugin_efiction_level', 1); 
                        }	
                    
					}	
					elseif($table == 'fanfiction_stats') {
						$insert = array(
							'sitekey'    =>  SITEKEY,
							'newestmember'  => USERID,
							'_DUPLICATE_KEY_UPDATE' => 1
						);
						e107::getDB()->insert("fanfiction_stats", $insert);
					}
                    
                   elseif($table == 'fanfiction_ratings') {
						$ratings = array(
							array("1","K 9+","",""),
							array("2","T 13+","",""),
                            array("3","M 16+","",""),
							array("4","MA 18+","","") 
						);

						foreach($ratings as $rating) {
						 
							$query = "INSERT INTO `#fanfiction_ratings` (`rid`, `rating`, `ratingwarning`, `warningtext`) VALUES('".$rating[0]."', '".$rating[1]."', '".$rating[2]."', '".$rating[3]."')";
							e107::getDB()->gen($query);		 
						}
					}
                    
 /*
     				$file =   e_PLUGIN.'efiction/sql/'.$table.'.xml';
                    if(file_exists($file) && is_readable($file)) {
                        $ret = e107::getXml(true)->e107Import($file);	 
                        
                        if (!empty($ret['success'])) {
                            e107::getMessage()->addSuccess(LAN_EFICTION_ADMIN_001);
                        }
            
                        if (!empty($ret['failed'])) {
                            e107::getMessage()->addError(LAN_EFICTION_ADMIN_002);
                            e107::getMessage()->addDebug(print_a($ret['failed'], true));
                        }
                    }
                    */
     			}            
            }
                   
        }
        
        /**
         * For inserting default database content during install after table has been created by the efiction_sql.php file.
         */
        public function install_post($var)
        {
 
            $this->add_default_data($var); 
            
			$this->fix_user_extended_fields($var);
        }

   
        function upgrade_required()
		{
 
         	foreach($this->tables_data AS $table) { 
                if(e107::getDb()->count($table) == 0)
     			{
                     return true;	 
     			}            
            }
        }

        public function uninstall_post($var)
        {
            // print_a($var);
        }

        public function upgrade_post($var)
        { 
           $this->add_default_data($var); 
			
        }
    }
}
