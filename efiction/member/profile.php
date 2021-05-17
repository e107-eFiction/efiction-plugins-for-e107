<?php

if (!defined('e107_INIT')) { exit; }
 
$displayprofile =  efiction::settings('displayprofile'); 
 
$profile_template = e107::getTemplate('efiction', 'profile', 'profile');  

$sc_profile = e107::getScBatch('profile', 'efiction');

$sc_profile->wrapper('profile/admin');  

$sc_profile->setVars($userinfo);

$profile_title = e107::getParser()->parseTemplate($profile_template['title'], true, $sc_profile);

if($displayprofile) {
    $profile_content = e107::getParser()->parseTemplate($profile_template['content'], true, $sc_profile);
}
else {
    $profile_content = e107::getParser()->parseTemplate($profile_template['admin'], true, $sc_profile);
}  
$profile_tablerender = varset($profile_template['tablerender'], 'profile');

$block_user_profile = e107::getRender()->tablerender($profile_title, $profile_content, $profile_tablerender, true);  
//clean after yourself
unset($profile_template, $profile_tablerender, $sc_profile, $profile_content );  
 