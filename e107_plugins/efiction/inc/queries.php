<?php
 
define ("_STORYQUERY",  "SELECT stories.*, author.penname as penname, UNIX_TIMESTAMP(stories.date) as date, UNIX_TIMESTAMP(stories.updated) as updated 
FROM (".MPREFIX."fanfiction_authors as author, ".MPREFIX."fanfiction_stories as stories) WHERE author.uid = stories.uid AND stories.validated > 0 ");