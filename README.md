# efiction plugin

IN DEVELOPMENT eFiction plugin for e107 


**Integration**

- [x] using class2.php
- [x] _BASEDIR - after moving to plugin correct value is define ("_BASEDIR", e_PLUGIN."efiction/"); 
- [x] language files e107::lan()

#### User/registration system

_Important_: Don't use e107 EUA in any case. It complicates things. 

- [x] replaced sessions 
- [x] separating users and authors, separated USERID and USERUID, isMEMBER is only for authors
- [x] added fanfiction_authors table to efiction plugin for adding user_id field, maybe will be removed, but with thousands users is easier manage authors directly 
- [ ] check delete authors functionality
- [ ] add delete or set level 4 for deleted e107 user
- [ ] check in clanmmember plugin for creating clanmember... it is similar solution

#### Moving everything under plugin

- [x] member.php e107::url('efiction','member')
- [x] viewserie.php e107::url('efiction','viewserie')
- [x] viewstory.php e107::url('efiction','viewstory')
- [x] viewpage.php e107::url('efiction','viewpage')
- [x] viewuser.php e107::url('efiction','viewuser')
- [x] toplists.php e107::url('efiction','toplists')
- [x] stories.php e107::url('efiction','stories')
- [x] series.php e107::url('efiction','series')
- [x] searching.php e107::url('efiction','searching')
- [x] rss.php e107::url('efiction','rss')
- [x] reviews.php e107::url('efiction','report')
- [x] authors.php e107::url('efiction','authors')
- [x] browse.php e107::url('efiction','browse')
- [x] report.php e107::url('efiction','report')
- [x] admin.php e107::url('efiction','adminarea')

#### header.php

- [x] integrated class2
- [x] e107::sessions() handler
- [x] e107::lan() handler
- [x] e107::css() 
- [x] e107::js() 

#### Header Fix
- [x] fixed header.php
- [x] paths to default .tpls files (originally in root) _BASEDIR."default_tpls/default.tpl"  
- [x] using HEADERF directly after including header.php - because admin part
- [x] removing any mention of header.tpl (+footer.tpl)
- [x] check and fix: "./default_tpls/ 
- [x] check and fix: ./$skindir/ 
- [x] check and fix: space+"default_tpls
DONE.

#### FOOTERF
- [x] adding FOOTERF + exit( ) everywhere after $tpl->printToScreen();
- [x] replace $tpl->printToScreen(); with:   
$output = $tpl->getOutputContent();  
$output = e107::getParser()->parseTemplate($output, true);
e107::getRender()->tablerender($caption, $output, $current);
- [x] replace $tpl->printToScreen( ) too
DONE

#### Paths to panels
- [x]  file_exists("user/" file_exists(_BASEDIR."user/"
- [x]  file_exists("browse/" file_exists(_BASEDIR."browse/


**user panels list**
- [ ] contact
- [ ] editbio
- [ ] editprefs
- [ ] favau
- [ ] favlist - used in viewuser.php
- [ ] favse
- [ ] favst
- [x] login - DELETED, managed by e107
- [x] logout - DELETED, managed by e107
- [x] lostpassword - DELETED, managed by e107
- [ ] manageimages 
- [ ] manfavs
- [ ] profile
- [ ] queries
- [x] register - DELETED, managed by e107
- [ ] reviewsby
- [ ] revreceived
- [ ] revres
- [ ] series by
- [ ] stats
- [ ] stories by
 
 **Sessions**

- [x] replacing session _viewed // This session variable is used to track the story views
- [x] replacing session _ageconsent
- [x] replacing session _warned

**Age controls**:
- [x] moving to UEA data? Decision: Not, it is easy to get Author data now. 
- [x] update title shortcode? 
- [x] fix viewstory.php





