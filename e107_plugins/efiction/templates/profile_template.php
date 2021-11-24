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

$PROFILE_TEMPLATE['author']['title'] = '{PROFILE_USERPENNAME}';
 
$PROFILE_TEMPLATE['author']['content'] = '
<div id="profile">
	<div class="panel-profile card text-left">
		<div class=" card-body"> 
			<div class="row member_penname m-2 border-bottom">
				<div class="ue-label col-12 col-sm-4">{LAN=_PENNAME}:</div>
				<div class="ue-value col-12 col-sm-8">{PROFILE_USERPENNAME}{PROFILE_NAMEINFO}</div>
			</div>
			{PROFILE_REALNAME}
	        {PROFILE_MEMBERSINCE}
            {PROFILE_USERLEVEL}
			 	
			<div class="row membership_status m-2 border-bottom">
				<div class="ue-label col-12 col-sm-4">{LAN=_BIO}</div>
				<div class="ue-value col-12 col-sm-8">{PROFILE_IMAGE}{PROFILE_BIO}:</div>
			</div> 
			{PROFILE_AUTHORFIELDS} 
		    {PROFILE_CODEBLOCK=userprofile}
		</div>
	</div> 
</div>
<div class=\"adminoptions\">{PROFILE_ADMINOPTIONS}</div> 
{PROFILE_REPORTTHIS: class=btn btn-light}';

$PROFILE_TEMPLATE['author']['tablerender']  = "simplecard";

$PROFILE_TEMPLATE['author']['admin']  = "<div class=\"adminoptions\">{PROFILE_ADMINOPTIONS}</div>";


$PROFILE_WRAPPER['profile']['PROFILE_REALNAME'] = '
<div class="row member_realname m-2 border-bottom">
<div class="ue-label col-12 col-sm-4">{LAN=_REALNAME}:</div><div class="ue-value col-12 col-sm-8">{---}</div></div>'; 

$PROFILE_WRAPPER['profile']['PROFILE_MEMBERSINCE'] = '
<div class="row member_realname m-2 border-bottom">
<div class="ue-label col-12 col-sm-4">{LAN=LAN_EFICTION_MEMBER_SINCE}:</div><div class="ue-value col-12 col-sm-8">{---}</div></div>'; 


$PROFILE_WRAPPER['profile']['PROFILE_USERLEVEL'] = '
<div class="row membership_status m-2 border-bottom">
<div class="ue-label col-12 col-sm-4">{LAN=LAN_EFICTION_MEMBERSHIP_STATUS}:</div><div class="ue-value col-12 col-sm-8">{---}</div></div>'; 

$PROFILE_WRAPPER['profile']['PROFILE_CODEBLOCK=userprofile'] = '
<div class="row codeblock m-2 border-bottom">{---}</div>'; 


$PROFILE_TEMPLATE['profile']['content'] = '{PROFILE_USERPENNAME}';




//$PROFILE_TEMPLATE['user'] = '{PROFILE_USERPENNAME}';
$PROFILE_TEMPLATE['user']['title'] = LAN_EFICTION_AUTHOR_PROFILE;
$PROFILE_TEMPLATE['user']['tablerender']  = "main2";

$PROFILE_TEMPLATE['user']['content'] = '
<div id="profile">
	<div class="card text-left">
		<div class="card-header">
           <div class="row member_penname">
				<div class="ue-label col-12 col-sm-4">{LAN=_PENNAME}:</div>
				<div class="ue-value col-12 col-sm-8">{PROFILE_USERPENNAME}{PROFILE_NAMEINFO}</div>
			</div>
        </div> 
        <div class="card-body panel-body"> 
 
				{PROFILE_REALNAME}
				{PROFILE_MEMBERSINCE}

			<div class="row membership_status m-2 border-bottom">
				<div class="ue-label col-12 col-sm-4">{LAN=LAN_EFICTION_MEMBERSHIP_STATUS}:</div>
				<div class="ue-value col-12 col-sm-8">{PROFILE_USERLEVEL}</div>
			</div>		
			 
			{PROFILE_AUTHORFIELDS} 
			<div class="row codeblock">
			 {PROFILE_CODEBLOCK=userprofile}
			</div>
		</div>
     <div class="card-footer adminoptions"> 
          {PROFILE_REPORTTHIS: class=btn btn-light}</div> 
      </div> 
</div>';


									 