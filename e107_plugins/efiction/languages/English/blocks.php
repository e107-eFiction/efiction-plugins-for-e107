<?php
/*
+----------------------------------------------------------------------+
|        e107 website content management system Language File
|        Released under the terms and conditions of the
|        GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------+
*/

// Blocks
define("LAN_EFICTION_BLOCKTYPE", "Block style");
define("LAN_EFICTION_DEFAULT", "Default");
define("LAN_EFICTION_FORMAT", "Format");
define("LAN_EFICTION_USETPL", "Use tpl");
define("LAN_EFICTION_TEMPLATE", "Template");
define("LAN_EFICTION_NA-TPL", "Not Available. Layout defined in .tpl file.");
define("LAN_EFICTION_SUMLENGTH", "Length of Summary");
define("LAN_EFICTION_STRIPTAGS", "Strip all tags");
define("LAN_EFICTION_ALLOWTAGS", "Allow tags");
define("LAN_EFICTION_SUMNOTE", "Default is 75 characters.");
define("LAN_EFICTION_NUMUPDATED", "Number of stories.");
 
/* category block */
define("LAN_EFICTION_NATPL", "Not Available. Layout defined in .tpl file.");   
define("_ONECOLUMN", "One Column List");
define("_MULTICOLUMN", "Multiple Columns");
define("_CATBLOCKNOTE", "Note: Selecting 'Use .tpl' will output the categories blocks in the 1.1 table format.");

/* countdown */
define ("_NOCOUNTDOWN", "There is no countdown active.");
define ("_TARGETDATE", "Target Date");
define ("_FINISHMESSAGE", "Finish Message");
define ("_COUNTDOWNFORMAT", "{days} days, {hours} hours, {minutes} minutes, {seconds} seconds.");
define ("_FORMATCOUNT", "Countdown Format");
define ("_COUNTDOWNOVER", "The countdown is over.");
define ("_COUNTDOWNACTIVE", "Countdown Active");
define ("_DATENOTE", "Target date should be in the format: MM/DD/YYYY HH:MM.  Use 24 hour clock for the time. Use the following variables in your countdown format string: {days}, {hours}, {minutes}, {seconds}.  To stop the countdown leave the target date blank.");
 
/* featured */
define("_FEATUREDSUMNOTE", "Default is 75 characters.");

//info block 
define("_CHART", "Chart");
define("_NARRATIVE", "Narrative");
define("_LOGGEDINAS", "You are currently logged in as");
define("_VARIABLES", "Variables");
define("_DISPLAY",  "Style of Display");
define("_NARTEXT", "We are the home of  {authors} authors from among our {members} members.  There have been {reviews} reviews written about our {stories} stories consisting of {chapters} chapters and {totalwords} words.  A special welcome to our newest member, {newest}. {loggedinas} {submissions}");
define("_NEWESTMEMBER", "Newest Member");
define("_REVIEWERS", "Reviewers");

/* menu */
define("_STYLE", "Style");
define("_LISTFORMAT", "Unordered List");
define("_NOLIST", "Links Only");


/*news*/
define ("_NUMNEWS", "Number of items");
define ("_READMORE", "Read more...");

/* online */
define("_GUESTS", "Guests");

/*polls*/
define("_ALREADYVOTED", "You have already voted!");
define("_VOTE", "Vote!");
define("_VOTECAST", "Your vote has been cast.");
define("_NOPOLL", "There is no poll currently active.");
define("_POLLQUESTION", "Poll Question: (limit 250 characters)");
define("_POLLARCHQUESTION", "Poll Question");
define("_POLLOPTS", "Poll Options: (Enter one per line. Note: tags will be stripped.)");
define("_CLOSEPOLL", "Close the current poll.");
define("_POLLARCHIVE", "Poll Archive");
define("_START", "Start");
define("_END", "End");
define("_POLLRESULTS", "Poll Results");

/* shoutbox */
define("_SHOUT", "Shout");
define("_NOSHOUTS", "No messages have been posted.");
if(!defined("_GUEST")) define("_GUEST", "Guest");
define("_EDITSHOUT", "Edit Shout");
define("_SHOUTARCHIVE", "Shout Archive");
define("_DELETESHOUTS", "Delete shouts older than ");
define("_DAYS", " days.");
define("_SHOUTDATE", "Shout Date Format");
define("_SHOUTLIMIT", "Shout Limit");
define("_GUESTSHOUTS", "Allow guests to shout");
define("_SHOUTEND", "End of shout.  Shouts are limited to 200 characters!");

define("_HELP_SHOUTDATEFORMAT", "The format for date (and optionally time) to be displayed in the shout box.  For custom fomats, use PHP's date format.");
