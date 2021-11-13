<?php

if (!defined('e107_INIT')) { exit; }


// v2.x Standard

include_once("includes/queries.php");

class efiction_rss // plugin-folder + '_rss'
{
	/**
	 * Admin RSS Configuration
	 */
	function config()
	{
		$config = array();

		$config[] = array(
			'name'			=> 'Last updated Stories',
			'url'			=> 'efiction',
			'topic_id'		=> '',
			'description'	=> 'this is the rss feed for the efiction plugin', // that's 'description' not 'text'
			'class'			=> e_UC_MEMBER,
			'limit'			=> '20'
		);

		return $config;
	}

	/**
	 * Compile RSS Data
	 * @param array $parms
	 * @param string $parms['url']
	 * @param int $parms['limit']
	 * @param int $parms['id']
	 * @return array
	 */
	function data($parms=array())
	{
		$sql = e107::getDb();

		$rss = array();
		$i=0;

        //$this -> rssItems[$k]['link'] = SITEURLBASE.e_PLUGIN_ABS.$row['link'];
        $url = "efiction/";
        
        $query = _STORYQUERY." ORDER BY updated DESC LIMIT 0,".$parms['limit'];
 
        $ratlist = $sql->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_ratings", true);
        foreach($ratlist AS $rate)
        {
        	$ratings[$rate['rid']] = $rate['rating'];
        }
 
		if($items = $sql->retrieve($query, true))
		{

		    foreach( $items AS $story)
			{
                $story['authors'][] = $story['penname'];
                if($story['coauthors']) {
            		$coauth = $sql->retrieve("SELECT "._PENNAMEFIELD." as penname, co.uid FROM ".TABLEPREFIX."fanfiction_coauthors AS co LEFT JOIN "._AUTHORTABLE." ON co.uid = "._UIDFIELD." WHERE co.sid = '".$story['sid']."'", true);
            		foreach($coauth AS $c) 
                    {
            			$story['authors'][] = $c['penname'];
            		}
                }
 
 
     
				$rss[$i]['author']			= $row['penname'];
				$rss[$i]['author_email']	= '';
				$rss[$i]['link']			= $url."viewstory.php?sid=".$story['sid'];
				$rss[$i]['linkid']			= $story['sid'];
				$rss[$i]['title']			= $story['title']." "._BY." ".implode(", ", $story['authors'])." [".$ratings[$story['rid']]."]";
				$rss[$i]['description']		= $story['summary'];
				$rss[$i]['category_name']	= '';
				$rss[$i]['category_link']	= '';
				$rss[$i]['datestamp']		= $story['updated'] ;
				$rss[$i]['enc_url']			= "";
				$rss[$i]['enc_leng']		= "";
				$rss[$i]['enc_type']		= "";

				$i++;
			}

		}

		return $rss;
	}



}
