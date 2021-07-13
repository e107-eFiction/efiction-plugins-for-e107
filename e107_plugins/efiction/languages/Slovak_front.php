<?php 

define ("LAN_EFICTION_BY", "od");
define ("LAN_EFICTION_READMORE", "Zistiť viac...");

define ("LAN_RECENTSTORIES", "Preklady aktualizované za posledných [x] dní.");
define ("LAN_REQUIRED_INFORMATION", "Povinné údaje");

define ("LAN_EFICTION_ACCOUNT", "Account Info");
define ("LAN_EFICTION_ADMINAREA", "Admin");
define ("LAN_EFICTION_FEATURED", "Featured Stories");
define ("LAN_EFICTION_HOME", "Home");
define ("LAN_EFICTION_CHALLENGES", "Challenges");
define ("LAN_EFICTION_LOGOUT", "Logout"); 
define ("LAN_EFICTION_NEWS", "News Archive");
define ("LAN_EFICTION_RSS", "<img src='"._BASEDIR."/images/xml.gif' alt='RSS' border='0'>");
define ("LAN_EFICTION_RULES", "Rules");
define ("LAN_EFICTION_TENS", "Top Tens");
define ("LAN_EFICTION_TOS", "Terms of Service");

define ("LAN_EFICTION_PARENTSERIES", "Parent Series");
define ("LAN_EFICTION_MEMBER_SINCE", "Člen od");
define ("LAN_EFICTION_MEMBERSHIP_STATUS", "Status členstva");
define ("LAN_EFICTION_ACTIVITYBY", "Activity by");
define ("LAN_EFICTION_RATED", "Rated");
 
define ("_ACTIONSUCCESSFUL", "Akcia bola úspešná.");
define ("_ACTIONCANCELLED", "Požadovaná akcia zrušená.");
define ("_ACTIVE", "Aktívne");
define ("_ADD", "Pridať");
define ("_ADDAUTHOR2FAVES", "Zaradiť medzi obľúbených prekladateľov");
define ("_ADDWRITER2FAVES", "Zaradiť medzi obľúbených autorov");
define ("_ADDTOFAVORITES", "Pridať k obľúbeným");
define ("_ADMINOPTIONS", "Admin Options");
define ("_AGECHECK", "Vyžadované odsúhlasenie veku");
define ("_AGECONSENT", "Podľa zákonov štátu, kde žijem, som dosiahol plnoletosť a tak môžem vidieť veci s obsahom pre dospelých. &nbsp; Súčasne si uvedomujem, že týmto potvrdením obídem podobné varovania aj u ďalších poviedok.");
define ("_ALL", "All");
define ("_ALLOWEDTAGS", "<span style=\"font-weight: bold; text-decoration: underline;\">Poznámka:</span> Povolené HTML tagy sú: ".htmlentities(preg_replace("/></", "> <", $allowed_tags)));
define ("_ALLSTORIES", "Všetky preklady");
define ("_ALPHA", "Abecedne");
define ("_ANONYMOUS", "Anonymne");
define ("_AUTHORSNOTES", "Poznámky autora");
define ("_BACK2ACCT", "Návrat do <a href=\"member.php\">your account</a> area.");
define ("_BACK2ADMIN", "Návrat do <a href=\"admin.php\">Admin</a> area.");
define ("_BACK2CATS", "Späť na hlavné kategórie");
define ("_BACK2PREVIOUS", "Späť na predchádzajúce.");
define ("_BACK2STORY", "<a href='viewstory.php?sid=%s'>Späť na preklad.</a>");
define ("_BACK2SERIES", "<a href='series.php?seriesid=%s'>Späť na preklady.</a>");
define ("_BACK2REVIEWS", "<a href='reviews.php?%s'>Späť na hodnotenia.</a>");
define ("_BY", "by");
define ("_CAPTCHAFAIL", "The security code you entered did not match.  Please <a href=\"javascript: history.back(1)\">try again.</a>");
define ("_CAPTCHANOTE", "Enter the security code shown below:");
define ("_CATEGORIES", "Kategórie");
define ("_CATEGORY", "Kategória");
define ("_CATLOCKED", "Táto kategória je uzavratá.");
define ("_CATOPTIONS", "Dostupné kategórie");
define ("_CLEAR", "Clear");
define ("_CHAPTER", "Kapitola");
define ("_CHAPTERS", "Kapitoly");
define ("_CHARACTERS", "Postavy");
define ("_CHOOSECAT", "Choose a Category");
define ("_CONFIRMDELETE", "Are you sure you want to delete this?");
define ("_COAUTHORSEARCH", "Type in the first few letters of the person's penname.  The first ten matches will appear in a list.  Click on the person's name to select them as a co-author.");
define ("_DELETE", "Vymazať");
define ("_DISLIKE", "dislike");
define ("_DOWN", "down arrow");
define ("_EDIT", "Upraviť");
define ("_EDITFAVORITES", "Upraviť obľúbené");
define ("_EMAIL", "E-mail");
define ("_EMAILFAILED", "The email could not be sent.  Please <a href='".SITEURL."contact.php'>contact the administrator</a> to report this problem.");
define ("_ERROR", "<strong>Error!</strong>We encountered an error.  Please go back and try again.");
define ("_FATALERROR", "<b>A fatal MySQL error was encountered.</b><br />");
define ("_FSTORY", "Feature");
define ("_GO", "Potvrdiť výber a pokračovať");
define ("_HALFSTAR", "half-star");
define ("_JAVASCRIPTOFF", "You must have javascript enabled for this form to work properly."); // Modified for version 3.0
define ("_LIKE", "like");
define ("_LOGIN", "Log In");
define ("_PLEASELOGIN", "Please login to access this feature.");
define ("_MEMBER", "Člen");
define ("_MEMBERS", "Členovia");
define ("_MOSTRECENT", "Najnovšie pridané");
define ("_MOVE", "Move");
define ("_MOVETOP", "Move to Top"); // Really only used in the admin files, but we need it in the header.
define (
"_MULTIPLECATEGORIES", 
"<span style=\"text-decoration: underline; font-weight: bold;\">Note:</span> You may select multiple categories.  
<u>Please be aware that when you select a category in the drop-down menu below, the options in the list will change to display that category's sub-categories.</u>
 Press the 'Select >' button to add it to your choices. You may clear your selections at any time using the 'Clear' button."
 );
define ("_MULTIPLESELECT", "Hold the CTRL key to make multiple selections.");
define ("_NAME", "Meno");
define ("_NAUGHTYWORDS", "You have triggered our bad language filters.  We require that all content not behind an age verification warning be suitable for all audiences.  This includes titles, summaries, and names (for anonymous reviews, challenges, etc.). Please <a href=\"javascript: history.back(1)\">try again.</a>");
define ("_NEXT", "Next");
define ("_NEW", "New!");
define ("_NO", "No");
define ("_NODBFUNCTIONALITY", "It appears no applicable database functionality for PHP has not been enabled in the php configuration for this website.  Please consult the PHP documentation or ask your hosting provider.");
define ("_NOMAILSENT", "We encountered an error.  No e-mail was sent.");
define ("_NONE", "None");
define ("_NOSKIN", "The skin you selected in your user profile seems to be missing.  The site's default skin will be used instead. Please edit your profile to choose another skin.");
define ("_NORESULTS", "No results found.");
define ("_NOTAUTHORIZED", "You are not authorized to access that function.");
define ("_NOTCONNECTED", "ERROR: Failed to connect to the database!");
define ("_OPTIONS", "Options");
define ("_OR", "or");
define ("_ORPHAN", "Orphan");
define ("_OTHERRESULTS", "Other Results");
define ("_PENNAME", "Penname");
define ("_PFSTORY", "Past Featured Story");
define ("_POSSIBLEHACK", "A hacking attempt has been detected.");
define ("_PREVIEW", "Preview");
define ("_PREVIOUS", "Previous");
define ("_PRINTER", "Printer");
define ("_ORDER", "Order");
define ("_RATING", "Prístupnosť");
define ("_RATINGS", "Prístupnosť");
define ("_REMOVE", "Odstrániť");
define ("_REQUIREDINFO", "Some of the required information is missing.  Please check your input.");
define ("_REVIEW", "Review");
define ("_REVIEWNOTE", "<span style=\"text-decoration: underline; font-weight: bold;\">Note:</span> You may submit either a rating or a review or both.");
define ("_REVIEWRATING", _RATING);
define ("_REVIEWS", "Hodnotenia");
define ("_RETIRE", "Retire");
define ("_RETIRED", "Retired");
define ("_RUSERSONLY", "Len registrovaní užívatelia");
define ("_SELECT", "Select");
define ("_SELECTCATS", "Selected Categories");
define ("_SERIES", "Séria");
define ("_SERIESES", "Série");
define ("_SORT", "Zoradiť");
define ("_STAR", "star"); 
define ("_STORIES", "Preklady");
define ("_STORY", "Preklad");
define ("_SUBMIT", "Submit");
define ("_SUMMARY", "Zhrnutie");
define ("_TEXT", "Text");
define ("_TINYMCETOGGLE", "Use tinyMCE");
define ("_TITLE", "Názov");
define ("_TOC", "Table of Contents");
define ("_TOPLEVEL", "Top Level Category"); // Really only used in the admin, but needs to load with the header.
define ("_UP", "up arrow");
define ("_WIP", "Rozpracované"); // Added 01/12/07
define ("_YES", "Yes");

// Login

define ("_REMEMBERME", "Remember Me");
define ("_MEMBERLOGIN", "Member Login");

// Browse
define ("_BROWSE", "Prezeranie");

define ("_EMAILSENT", "Váš email bol odoslaný.");
define ("_TITLES", "Názvy");
// Contact Us
define ("_YOUREMAIL", "Váš email");
define ("_CONTACTUS", "Kontaktujte nás");

// Members/Authors page
define ("_AUTHORS" , "Prekladatelia");
define ("_BETAS", "Beta-readeri");
define ("_ALLMEMBERS", "Všetci členovia");
define ("_SITEADMINS", "Administrátori");

// News
define ("_COMMENTS", "Komentáre");
define ("_NEWS", "Novinky");

// Reviews
define ("_ALREADYRESPONDED", "You have already responded to that review!");
define ("_BACKTOSTORY", "Back to story.");
define ("_DELETEREVIEW", "Delete Review");
define ("_DISLIKED", "Disliked");
define ("_LIKED", "Liked");
define ("_MISSINGINFO", "You must supply either a review or rating.");
define ("_MISSINGINFO2", "Rating a story without writing a review is not allowed.  You must write a review.");
define ("_OPINION", "Opinion");
define ("_RESPECTNOTE", " Please be respectful and polite when contacting an author.");
define ("_RESPOND", "Respond");
define ("_REVEMAIL1", "New Review at $sitename for ");
define ("_REVEMAIL2", "Hello,
  You have received a new review at $sitename.\r\n You can view your new review at <a href='$url/reviews.php?%1\$s'>$url/reviews.php?%1\$s</a>.
If you no longer wish to receive e-mails such as this, please go to <a href='$url/user.php'>your account</a>\r\n
on $sitename, and edit your profile."); // Modified 11-12-05
define ("_REVIEWSFOR", "Reviews For");
define ("_REVTHANKYOU", "Thank you for your review!");
define ("_SIGNED", "Signed");
define ("_VIEWALLREVIEWS", "View All Reviews");

// Search

define ("_10LISTS", "Top Ten Lists");
define ("_10LARGESERIES", "Ten Largest Series");
define ("_10SMALLSERIES", "Ten Smallest Series");
define ("_10REVIEWEDSERIES", "Ten Most Reviewed Series");
define ("_10FAVSERIES", "Ten Favorite Series");
define ("_10SHORTSTORY", "Ten Shortest Stories");
define ("_10LONGSTORY", "Ten Longest Stories");
define ("_10REVIEWEDSTORY", "Ten Most Reviewed Stories");
define ("_10FAVSTORY", "Ten Favorite Stories");
define ("_10FAVAUTHOR", "Ten Favorite Authors");
define ("_10PROLIFICAUTHOR", "Ten Most Prolific Authors");
define ("_10PROLIFICREVIEWER", "Ten Most Prolific Reviewers");
define ("_ADVANCED", "Advanced Search");
define ("_COMPLETEONLY", "Len dokončené");
define ("_EXCLUDE", "to Exclude");
define ("_FULLTEXT", "Full Text");
define ("_INCLUDE", "to Include");
define ("_RESULTS", "Search Results");
define ("_SEARCHTERM", "Search term");
define ("_SEARCHTERMTOOSHORT", "Your search term was too short.  Your search term must be a minimum of three characters long. <a href='search.php'>Try again.</a>");
define ("_SIMPLE", "Simple Search");
define ("_WORDCOUNT", "Word count");
define ("_SEARCH", "Search");

// Series
define ("_ADD2SERIES", "Pridať poviedku");
define ("_ADDSERIES", "Pridať novú sériu");
define ("_ADDSERIES2FAVES", "Pridať sériu k obľúbeným");
define ("_BACKTOSERIES", "Späť k sérii"); // Added 11-06-05
define ("_CHOOSEAUTHOR", "Vybrať iného autora");
define ("_CLOSED", "Uzavreté"); // Added 02-10-07
define ("_CONFIRMREMOVE", "Are you sure you want to remove this from the series?"); // Added 12-22-05
define ("_DELETESERIES", "Delete Series");
define ("_EDITSERIES", "Edit Series");
define ("_MANAGESERIES", "Manage Series");
define ("_MODERATED", "Moderated"); // Added 02-10-07
define ("_OPEN", "Open");
define ("_OPENNOTE", "<span style=\"font-weight: bold; text-decoration: underline;\">Note:</span>  An open series is a shared universe (sometimes called a sandbox) in which other authors may add to the series.  
By marking your series as open, <u>other authors will be able to add to the series.</u>  A moderated series will allow other authors to add to the series, but those entries must be approved by the series owner. 
Only the series owner (and the site admins) may add to a closed series.");
define ("_REMOVEFROM", "Remove From Series");
define ("_SERIESNOTE", "<span style=\"font-weight: bold; text-decoration: underline;\">Note:</span>  You will choose the stories to add to your series on the next page.");
define ("_SERIESNOTE2", "<span style=\"font-weight: bold; text-decoration: underline;\">Note:</span>  You will set the order of your stories and subseries on the next page.");
define ("_SERIESTYPE", "Series Type"); // Added 02-10-07
define ("_SERIESTITLEREQUIRED", "A title for the series is required!");
define ("_NEWSERIESITEMS", "New items have been submitted to your series, %1\$s, at $sitename.  To validate these additions log in to your account.");
define ("_SERIESITEMSSUBS", "New items for %1\$s at $sitename");

// Stories

define ("_ADDNEWCHAPTER", "Add New Chapter");
define ("_ADDNEWSTORY", "Add New Story");
define ("_ADDSTORY", "Add Story");
define ("_AUTHOR", "Author");
define ("_AUTHORALERTNOTE", "One of your favorite authors at $sitename has posted a new story.<br><br>%1\$s "._BY." %2\$s<br><br>%3\$s<br><br><a href=\"$url/viewstory.php?sid=%4\$d\">$url/viewstory.php?sid=%4\$d</a>If you no longer wish to receive e-mails such as this, please go to <a href='$url/user.php'>your account</a>\r\n
on $sitename, and edit your profile.");  // Modified 2-3-10 to add reminder for turning off alerts
define ("_CHAPTERNOTES", "Chapter Notes");
define ("_CHAPTERTITLE", "Chapter Title");
define ("_COAUTHORS", "Co-Authors");
define ("_COMPLETE", "Complete");
define ("_CURRENT", "Current");
define ("_DELETECHAPTERTITLE", "Delete Chapter");
define ("_DELETESTORY", "Are you sure you want to delete this story? All chapters beneath it will be deleted as well!");
define ("_DELETESTORYTITLE", "Delete Story");
define ("_EDITCHAPTER", "Edit Chapter");
define ("_EDITSTORY", "Edit Story");
define ("_ENDNOTES", "End Notes");
define ("_FEATURED", "Featured");
define ("_HIDECHAPTERS", "Hide Chapters");
define ("_INVALIDUPLOAD", "Invalid Upload!  File uploads must be in plain text or html format.");
define ("_LOCKED", "This category is locked.");
define ("_MANAGESTORIES", "Manage Stories");
define ("_MISSINGFIELDS", "Some of the required information is missing.  Please check your input.  Required fields are title, summary, ".($multiplecats ? strtolower(_CATEGORIES.", ") : "")."rating, and story text."); // Modified 11/06/05 - If categories are turned off don't show category as required field. :)
define ("_NEWSTORYAT", "New Story at ");
define ("_NEWSTORYAT2", "A new story has been submitted to the validation queue at $sitename.<br><br> %1\$s by %2\$s<br><br>%3\$s\n\nIf you no longer wish to receive e-mails such as this, please go to <a href='$url/user.php'>your account</a>\r\n
on $sitename, and edit your profile.");  // Modified 2-3-10 to add reminder for turning off alerts
define ("_NOSTORYTEXT", "You must include the text of your story either as an upload or as input into the textarea.");
define ("_READS", "Read Count");
define ("_ROUNDROBIN", "Round robin");
define ("_STORYADDED", "Your story has been added. If the admin is reviewing submissions, then it will appear to the public after they have okayed it. In the meantime, you can always edit the story in your account area.");
define ("_STORYALERT", "Update to favorites at $sitename");
define ("_STORYALERTNOTE", "%1\$s by %2\$s, one of your favorite stories at $sitename, has been updated.<br><br><a href=\"$url/viewstory.php?sid=%3\$d&amp;chapter=%4\$d\">$url/viewstory.php?sid=%3\$d&amp;chapter=%4\$d</a>\n\nIf you no longer wish to receive e-mails such as this, please go to <a href='$url/user.php'>your account</a>\r\n
on $sitename, and edit your profile."); // Modified 2-3-10 to add reminder for turning off alerts
define ("_STORYNOTES", "Story Notes");
define ("_STORYTEXTTEXT", "Story Text (text)");
define ("_STORYTEXTFILE", "Story Text (file)");
define ("_STORYUPDATED", "The story has been updated.");
define ("_VALIDATED", "Validated");
define ("_VIEWCHAPTERS", "View Chapters");
define ("_WORDCOUNTFAILED", "Your story failed to meet the required minimum or maximum word count for story submission on this site.  Each chapter must be".($minwords ? " no less than ".$minwords : "").($maxwords ? ($minwords ? " and" : "")." no more than $maxwords " : "")." words long.");

// User

define ("_USERACCOUNT", "Váš účet");

// User --  Edit prefs
define ("_ALERTSON2", "Contact when favorites are updated.");
define ("_BETANOTE", "I would like to volunteer to be a beta-reader for others.");
define ("_CONTACTREVIEWS", "Contact for new reviews");
define ("_CONTACTRESPOND", "Contact when author responds to review");
define ("_DEFAULTSORT", "Default Story Sort");
define ("_DISPLAYINDEX", "Display table of contents for stories.");
define ("_EDITPREFS", "Edit Preferences");
define ("_REQUIREDFIELDS", "Indicates required fields.");
define ("_SKIN", "Skin");
define ("_USETINYMCE", "Use tinyMCE WYSWYG editor");

// User - Edit Bio/Registration (default)
define ("_AOL", "AOL IM");
define ("_BADEMAIL", "That address doesn't appear to be in our database. Please <a href=\"member.php?action=lostpassword\">try again.</a>");
define ("_BADUSERNAME", "Sorry! Usernames can only contain letters, numbers, underscores, hyphens, or spaces, and must be between 3 and 20 characters long.");
define ("_BIO", "Bio");
define ("_EDITPERSONAL", "Edit Personal Information");
define ("_EMAILINUSE", "This email address has already been used to sign up for an account. If you've lost your password, please generate a new one by using the <a href=\"member.php?action=lostpassword\">lost password</a> feature.");
define ("_ICQ", "ICQ");
define ("_INVALIDEMAIL", "The e-mail address you supplied is an invalid format.");
define ("_NEWACCOUNT", "Nový účet");
define ("_NEWPEN", "%1\$s ( %2\$d ) changed penname %3\$s ( %4\$d ) to %5\$s.");
define ("_MSN", "MSN IM");
define ("_PASSWORD", "Password");
define ("_PASSWORD2", "Confirm Password");
define ("_PASSWORDTWICE", "You must enter your new password twice. Please <a href=\"member.php?action=".$action."\">try again</a>.");
define ("_PWDREQUIRED", "A password is required to access this function.");
define ("_PENEMAILREQUIRED", "You must fill out the penname and email fields. Please <a href=\"member.php?action=newaccount\">try again</a>.");
define ("_PENNAMEINUSE", "This penname is already in use.");
define ("_REALNAME", "Real name");
define ("_REGISTER", "Register");
define ("_REGLOG", "%1\$s (%2\$d) registered from IP address %3\$s.");
define ("_SIGNUPSUBJECT", "Welcome to $sitename");
define ("_SIGNUPMESSAGE", "Hello, you or someone using your email has signed you up at $sitename. Your login and password are below:\n\n");
define ("_SIGNUPTHANKS", "Thank you for signing up! You will receive ".(!$pwdsetting ? "your temporary password" : "a confirmation")." at the e-mail address you provided.");
define ("_SIGNUPWARNING",  "It is recommended that you log in and change the password to something easier for you to remember.");
define ("_TRYAGAIN", "Please try again.");
define ("_WEBSITE", "Website");
define ("_YAHOO", "Yahoo IM");

// User - Image Management

define ("_ALLOWEDEXT","Only files with the following extensions are allowed: ");
define ("_ALREADYEXISTS", "Uploading <strong>%s...Error!</strong> Sorry, a file with this name already exists.");
define ("_BADFILENAMES", "You have tried to upload the following files with invalid characters inside the filename.");
define ("_FILENAME", "Filename");
define ("_FILENOTEXISTS", "The file <strong>%s</strong> does not exist.");
define ("_IMAGE", "Image");
define ("_IMAGECODE", "HTML code to use image in story");
define ("_IMAGETOOBIG", "This image is too big. Images may only be $imagewidth wide by $imageheight high. Please <a href=\"member.php?action=manageimages&upload=upload\">try again</a>.");
define ("_INVALIDNAME", "Sorry, the filename contains invalid characters. Use only alphanumerical chars and separate parts of the name (if needed) with an underscore. <br>A valid filename ends with one dot followed by the extension.");
define ("_MANAGEIMAGES", "Manage Images");
define ("_MAXFILENAME", "The filename exceeds the maximum length of %s characters.");
define ("_MAXFSSERVER", "The uploaded file exceeds the max. upload filesize directive in the server configuration.");
define ("_MAXFSFORM", "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.");
define ("_NODIRECTORY", "Sorry, the upload directory doesn't exist!");
define ("_NOFILESSELECTED", "Select at least on file.");
define ("_NOFILESELECTED", "No file was uploaded.");
define ("_PARTIALUPLOAD", "The uploaded file was only partially uploaded");
define ("_RENAMEDTO", "The uploaded file was renamed to <b>%s</b>.");
define ("_SELECTFILE", "Please select a file for upload.");
define ("_UPLOADIMAGE", "Upload New Images");
define ("_UPLOADSUCCESS", "<strong>%s</strong> successfully uploaded!");
define ("_VIEW", "View");
define ("_WRONGEXT", "You have tried to upload %1\$d files with a bad extension, the following extensions are allowed: <strong>%2\$s</strong>");

// User - Lost password

define ("_ENTEREMAIL", "Enter your e-mail address");
define ("_LOSTPASSWORD", "Lost password");
define ("_NEWPWDSUB", "New Password for $sitename");
define ("_NEWPWDMSG", "Hello, you appear to have requested a new password for $sitename. Your new password is:\n\nPassword: %s\n\nIt is recommended that you log in and change the password to something easier for you to remember.");
define ("_PASSWORDSENT", "A new password has been sent to your e-mail address.");

// User - Stats

define ("_AUTHOROF", "Ste prekladateľom/autorom:");
define ("_FAVOF", "Ste obľúbeným prekladateľom pre:  ");
define ("_FAVORITE", "Favorite");
define ("_MANAGEREVIEWS", "Manage Your Reviews");
define ("_STATSFOR", "Štatistika pre ");
define ("_UNRESPONDED", "Unresponded");
define ("_YOURFAVORITES", "Máte vo svojich obľúbených:");
define ("_YOURSTATS", "Vaše štatistiky");
define ("_YOURREVIEWS", "Vaše hodnotenia");

// User - Manage Favorites

define ("_MANAGEFAVORITES", "Správa obľúbených");
define ("_REMOVEFAV", "Vyradiť z obľúbených");

// User - Login

define ("_WRONGPASSWORD", "That password doesn't match the one in our database. Please <a href=\"member.php?action=login\">try again</a> or retrieve a <a href=\"member.php?action=lostpassword\">new password</a> if you can't remember yours.");
define ("_ACCOUNTLOCKED", "This account has been locked by the adminstrators of this site.  Please <a href='".SITEURL."contact.php'>contact</a> the site adminstrators for more information.");
define ("_NOSUCHACCOUNT", "There is no such account on our website."); // Added 6-18-2008

// User - Review Response
define("_AUTHORSRESPONSE", "Author's Response");
define ("_RESPONSESUBJECT", "Author Response to Your Review at $sitename");
define ("_RESPONSETEXT", "{penname} has responded to your review.\r\n\r\nYou can see the response at <a href=\"".$url."/reviews.php?reviewid={review}\">".$url."/reviews.php?reviewid={review}</a>");

// View story

define ("_ACCESSDENIED", "Access denied. This story has not been validated by the adminstrators of this site.");
define ("_ARCHIVEDAT", "This story archived at");
define ("_BACK2INDEX", "Back to index");
define ("_CONTINUE", "Continue");
define ("_CONTRIBUTE2RR", "Contribute to Round Robin");
define ("_INVALIDSTORY", "That story does not exist on this archive.  You may <a href='search.php'>search</a> for it or return to <a href='index.php'>the home page.</a>");
define ("_LOGINTOREVIEW", "You must %1\$s (%2\$s) to review.");
define ("_SUBMITREVIEW", "Odoslať nové hodnotenie");
define ("_TEXTSIZE", "Text Size");

// View User

define ("_ADMINISTRATOR", "Administrator");
define ("_CONTACT", "Contact");
define ("_CONTACTAUTHOR", "Contact Author:");
define ("_EDITADMIN", "Edit Admin Privileges");
define ("_FAVORITEAUTHORS", "Obľúbení prekladatelia"); // Added for 3.0
define ("_FAVORITESERIES", "Obľúbené série"); // Added for 3.0
define ("_FAVORITESTORIES", "Obľúbené preklady"); // Added for 3.0
define ("_FAVORITESOF", "Favorites of "); // Added for 3.0
define ("_LOCKMEM", "Uzamknutý účet");
define ("_MAKEADMIN", "Make User an Admin");
define ("_REVOKEADMIN", "Revoke Admin Privileges");
define ("_REVOKEVAL", "Revoke Validation");
define ("_REVIEWSBY", "Reviews by ");
define ("_SERIESBY", "Series by ");
define ("_SITESIG", "This message was sent to you from $sitename located at <a href='$url'>$url</a>.");
define ("_SITESIG2", "This message was sent to you by %s from $sitename located at <a href='$url'>$url</a>.");
define ("_STORIESBY", "Autor prekladu");
define ("_SUBJECT", "Predmet");
define ("_UNLOCKMEM", "Odomknúť účet");
define ("_VALIDATE", "Schváliť");

// Tooltip help for various items.  
define ("_HELP_NEWREV", "Check this box if you wish to receive an e-mail notice each time you get a new review.");
define ("_HELP_NEWRESP", "Check this box if you wish to receive an e-mail notice each time an author resonds to your review.");
define ("_HELP_FAVALERT", "Check this box if you wish to receive an e-mail notice each time one of your favorite stories is updated or when one of your favorites author's publishes a new story.");
define ("_HELP_BETA", "Check this box if you are willing to have other author's contact you to read their stories before they are published and provide the feedback and help the author requests.");
define ("_HELP_TOC", "Check this box if you wish to see the story index first rather than the first chapter of the story on multi-chapters.");
define ("_HELP_TINYMCE", "Check this box if you wish to use the tinyMCE editor when entering content in forms.  You will have the option to toggle the editor on/off if need be.");
define ("_HELP_AGE", "By agreeing, you are confirming you are above the age of majority in your locality and that you wish to view the adult oriented material on this site.");
define ("_HELP_DEFAULTSORT", "Select the order in which to sort stories by default.  Your choices are Alphabetically or Most Recent (newest to oldest).");
define ("_HELP_SKIN", "Choose the appearance of the site.");

// Log strings
define ("_LOG_ADMIN_DEL", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> deleted <a href='viewstory.php?sid=%4\$d'>%3\$s</a> by <a href='viewuser.php?uid=%6\$d'>%5\$s</a>.");
define ("_LOG_ADMIN_EDIT", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> edited <a href='viewstory.php?sid=%4\$d'>%3\$s</a> by <a href='viewuser.php?uid=%6\$d'>%5\$s</a>.");
define ("_LOG_ADMIN_DEL_CHAPTER", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> deleted <a href='viewstory.php?sid=%4\$d'>%3\$s</a> by <a href='viewuser.php?uid=%6\$d'>%5\$s</a>, chapter %7\$d");
define ("_LOG_ADMIN_EDIT_CHAPTER", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> edited <a href='viewstory.php?sid=%4\$d'>%3\$s</a> by <a href='viewuser.php?uid=%6\$d'>%5\$s</a>, chapter %7\$d");
define ("_LOG_ADMIN_EDIT_AUTHOR", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> changed the author of <a href='viewstory.php?sid=%4\$d'>%3\$s</a> by <a href='viewuser.php?uid=%8\$7'>%5\$s</a> to <a href='viewuser.php?uid=%6\$d'>%5\$s</a>.");
define ("_LOG_ADMIN_DEL_SERIES", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> deleted the series '%3\$s'.");
define ("_LOG_ADMIN_EDIT_SERIES", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> edited the series '<a href='viewseries.php?seriesid=%4\$d'>%3\$s</a>'.");
define ("_LOG_ADMIN_DEL_FROM_SERIES", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> deleted <a href='viewstory.php?sid=%4\$d'>%3\$s</a> by <a href='viewuser.php?uid=%6\$d'>%5\$s</a> from '<a href='viewseries.php?seriesid=%8\$d'>%7\$s</a>.'");
define ("_LOG_BAD_LOGIN", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> entered a wrong password trying to log in.");
define ("_LOG_LOST_PASSWORD", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> requested a new password.  Password sent: %3\$s.");
define ("_LOG_ADMIN_REG", "%1\$s (%2\$d) was registered by %3\$s (%4\$d) from IP address %5\$s.");
define ("_LOG_REGISTER", "%1\$s (%2\$d) registered from IP address %3\$s.");
define ("_LOG_REVIEW", "%1\$s wrote '%2\$s' as a review for '%3\$s'.");
define ("_LOG_EDIT_REVIEW", "<a href='viewuser.php?uid=%2\$d'>%1\$s</a> edited <a href='reviews.php?reviewid=%4\$d'>a review</a> for '%3\$s'.");

// Report Types

define ("_REPORT", "Report");
define ("_MISSING", "Missing Information");
define ("_RULESVIOLATION", "Violation of Rules");
define ("_BUGREPORT", "Bug Report");
define ("_REPORTTHIS", "Report This");


define("_NEWESTMEMBER", "Najnovší člen");
define("_REVIEWERS", "Hodnotilo");
define("_LOGGEDINAS", "You are currently logged in as");