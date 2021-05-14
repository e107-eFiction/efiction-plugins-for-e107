<?php

if (!defined('e107_INIT')) {
    exit;
}

/*
<!-- START BLOCK : profile -->
<div id="profile">
<div id="bio">
	<div id="biotitle"><span class="label">Penname: </span>{userpenname} <span class="label">Real name: </span>{realname}</div>
	<div id="biocontent">
		<span class="label">Member Since: </span>{membersince}<br />
		<span class="label">Membership status:</span> {userlevel}<br />
		<span class="label">Bio:</span><br>{image}{bio}<br />
		{authorfields} 
	</div>
</div>
{adminoptions} {reportthis}
</div>
<!-- END BLOCK : profile -->
*/
/* default rewrited
$PROFILE_TEMPLATE['profile']['title'] = '{PROFILE_USERPENNAME}';

$PROFILE_WRAPPER['profile']['MEMBER_AUTHORFIELDS'] = '<div class="panel-profile"><div class="panel-body">{---}</div></div>';

$PROFILE_TEMPLATE['profile']['content'] = '
<div id="profile">
<div id="bio">
	<div id="biotitle"><span class="label">{LAN=_PENNAME}: </span>{PROFILE_USERPENNAME}{PROFILE_NAMEINFO} <span class="label">{LAN=_REALNAME}: </span>{PROFILE_REALNAME}</div>
	<div id="biocontent">
		<span class="label">{LAN=LAN_EFICTION_MEMBER_SINCE}: </span>{PROFILE_MEMBERSINCE}<br />
		<span class="label">{LAN=LAN_EFICTION_MEMBERSHIP_STATUS}:</span> {PROFILE_USERLEVEL}<br />
		<span class="label">{LAN=_BIO}:</span><br>{PROFILE_IMAGE}{PROFILE_BIO}<br />
		{PROFILE_AUTHORFIELDS} 
	
		{PROFILE_CODEBLOCK=userprofile}
	</div>
</div>
{PROFILE_ADMINOPTIONS} {PROFILE_REPORTTHIS}
</div>
';
*/
/* example of custom template */

$PROFILE_TEMPLATE['profile']['title'] = '{PROFILE_USERPENNAME}';

$PROFILE_WRAPPER['profile']['MEMBER_AUTHORFIELDS'] = '<div class="panel-profile"><div class="panel-body">{---}</div></div>';

$PROFILE_TEMPLATE['profile']['content'] = '
<div id="profile">
<div id="bio">
	<div id="biotitle"><span class="label">{LAN=_PENNAME}: </span>{PROFILE_USERPENNAME}{PROFILE_NAMEINFO} <span class="label">{LAN=_REALNAME}: </span>{PROFILE_REALNAME}</div>
	<div id="biocontent">
		<span class="label">{LAN=LAN_EFICTION_MEMBER_SINCE}: </span>{PROFILE_MEMBERSINCE}<br />
		<span class="label">{LAN=LAN_EFICTION_MEMBERSHIP_STATUS}:</span> {PROFILE_USERLEVEL}<br />
		<span class="label">{LAN=_BIO}:</span><br>{PROFILE_IMAGE}{PROFILE_BIO}<br />
		{PROFILE_AUTHORFIELDS} 
	
		{PROFILE_CODEBLOCK=userprofile}
	</div>
</div>
{PROFILE_ADMINOPTIONS} {PROFILE_REPORTTHIS}
</div>';

$PROFILE_TEMPLATE['profile']['tablerender']  = "simplecard";