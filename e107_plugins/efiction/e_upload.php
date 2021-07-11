<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2016 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */


if (!defined('e107_INIT')) { exit; }

// v2 e_upload addon.

class efiction_upload
{

	function config()
	{
		$config = array(
			'name'			    => LAN_PLUGIN_EFICTION_NAME, // Prune downloads history
            'owner'             =>  'efiction'
			'table'		        => "download",  // table to insert upload data into.
			'media'	            => array(
									 
									'preview'   => '_common_image',  // media-category for screenshot/preview imported file.
									),
		 
		);

		return $config;
	}


	/**
	 * Compile Array Structure
	 */
	private function compile(&$inArray, &$outArray, $pid = 0)
	{
	   
	}

 

	function insert($upload)
	{

		 $ret = array(
            'download_name'             => $upload['upload_name'],
            'download_url'              => $upload['upload_file'],
            'download_sef'              => eHelper::title2sef($upload['upload_name']),
            'download_author'           => $upload['upload_poster'],
            'download_author_email'     => $upload['upload_email'],
            'download_author_website'   => $upload['upload_website'],
            'download_description'      => $upload['upload_description'],
            'download_keywords'         => null,
            'download_filesize'         => $upload['upload_filesize'],
            'download_requested'        => 0,
            'download_category'         => $upload['upload_category'],
            'download_active'           => 1,
            'download_datestamp'        => $upload['upload_datestamp'],
            'download_thumb'            => null,
            'download_image'            => $upload['upload_ss'],
            'download_comment'          => 1,
            'download_class'            => e_UC_MEMBER,
            'download_visible'          => e_UC_MEMBER,
            'download_mirror'           => null,
            'download_mirror_type'      => 0,
        );

        return $ret;

	}



}