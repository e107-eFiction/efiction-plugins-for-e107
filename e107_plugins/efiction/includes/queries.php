<?php

// Default query strings used throughout the script.  You may need to alter these to bridge to other scripts or databases.

define ("_AUTHORPREFIX", MPREFIX);

define ("_UIDFIELD", "author.uid");  // Do not change the aliasing (the "author." part)!
define ("_PENNAMEFIELD", "author.penname");  // Do not change the aliasing (the "author." part)!
define ("_EMAILFIELD", "author.email");  // Do not change the aliasing (the "author." part)!
define ("_PASSWORDFIELD", "author.password"); //  Do not change the aliasing (the "author." part)!



 
define ("_SERIESQUERY", "SELECT series.*, "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE.", ".TABLEPREFIX."fanfiction_series as series WHERE "._UIDFIELD." = series.uid ");
define ("_SERIESCOUNT", "SELECT COUNT(seriesid) AS count FROM ".TABLEPREFIX."fanfiction_series as series ");
define ("_MEMBERLIST", "SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid, ap.stories AS stories FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs AS ap ON "._UIDFIELD." = ap.uid");
define ("_MEMBERCOUNT", "SELECT COUNT("._UIDFIELD.") AS count FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs AS ap ON ap.uid = "._UIDFIELD);
?>