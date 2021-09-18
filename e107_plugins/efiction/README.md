# eFiction customized for future combination with e107

##This is still the standalone efiction version but without conflicts with e107

This is just backup and notes... THIS REPO contains files before changing the efiction code itself. The main reason is for it is to have been able to start from the beginning if integration ends dead end.


## Database changes 
*None*

Use the same prefix.

Prefix for e107: e107_
Prefix for efiction:  e107_ 

All efiction tables will look:
e107_fanfiction_xxx

All e107 tables will look:
e107_xxx

## Files

Only problem if you use e107 and efiction on the same level (what is the final goal):

index.php  
news.php
user.php
search.php
contact.php

### user.php
rename to member.php for efiction

Note: e107 clears sessions, so class2.php has to be loaded after get_session_vars.php  

### search.php

rename to searching.php for efiction

### news.php

renamed to ffnews.php for efiction

### index.php

- with efiction and e107 on the same level, only one can be used. e107 index.php is recommended because possibility of github synchronization. 
- it could be renamed to efiction.php  

### contact.php

renamed to report.php

## Other changes

Deleted docs. Content was moved to:

https://docs.e107sk.com/efiction-3-5-5/

Deleted bridges. 
e107 Alt Auth plugin is better alternative.




