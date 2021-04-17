<?php
// ----------------------------------------------------------------------
// Copyright (c) 2010 by Kirstyn Amanda Fox
// Based on DisplayWorld for eFiction 3.0
// Copyright (c) 2005 by Tammy Keefer
// Valid HTML 4.01 Transitional
// Based on eFiction 1.1
// Copyright (C) 2003 by Rebecca Smallwood.
// http://efiction.sourceforge.net/
// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------


if (!defined('e107_INIT')) { exit; }
 
    $writer = $stories['writer'];  
    $original_title = $stories['original_title']; 
    $original_url = $stories['original_url']; 
    $preklad_url = $stories['preklad_url']; 
    $multichapter = $stories['multichapter'];
    $source = $stories['source'];
 
    $writerquery = "SELECT cw_author_id, cw_author_name FROM ".TABLEPREFIX."fanfiction_writers ORDER BY cw_author_name ";
    $writersarray = e107::getDb()->retrieve($writerquery, true);
	foreach($writersarray AS $writerresult) {
		$writers[$writerresult['cw_author_id']] = $writerresult['cw_author_name'];
    }
 
    $output .= '<div class="title"><h3>Informácie o originále a nastavení</h3></div>';
    $output .= '<div class="row">';
	$output .= '<div class="form-group col-lg-4 col-md-4 col-sm-12">
					<label for="uid" class=" col-form-label">'._ORIGINAL_WRITER.'</label>
						<div>
						'.$frm->select('writer', $writers, $uid, array( 'class'=> 'custom-select-box', 'required' => 1), _ORIGINAL_WRITER).'
						</div>
				</div>';
                     
    $output .= '<div class="form-group col-lg-8 col-md-8 col-sm-12">
				<label for="storytitle" class="  col-form-label">'._ORIGINAL_TITLE.'</label>
					<div>
					'.$frm->text('original_title', htmlentities($original_title), 200, array('size' => 'large', 'required' => 1, 'id'=>'original_title')).'
					</div>
			  </div>';
    $output .= '</div>';       
    $output .= '<div class="row">';
	$output .= '<div class="form-group col-lg-6 col-md-6 col-sm-12">
				<label for="storytitle" class="col-form-label">'._ORIGINAL_URL.'</label>
					<div>
					'.$frm->text('original_url', htmlentities($original_url), 200, array('size' => 'large', 'required' => 1, 'id'=>'original_url')).'
					</div>
			  </div>';
    $output .= '<div class="form-group  col-lg-6 col-md-6 col-sm-12">
				<label for="storytitle" class="col-form-label">'._PREKLAD_URL.'</label>
					<div>
					'.$frm->url('preklad_url', htmlentities($preklad_url), 200, array('size' => 'large', 'required' => 1, 'id'=>'preklad_url')).'
					</div>
			  </div>';
    $output .= '</div>';    
    $output .= '<div class="row">';  
	$output .= '<div class="form-group col-lg-6 col-md-6 col-sm-12">
				    <label for=\"multichapter\">Kapitolovka</label>
					<div>
					'.e107::getForm()->radio_switch('multichapter', $multichapter, _YES, _NO).'
					</div>
			    </div>';   
                
    $sources['none'] =  'Neurčený';
    $sources['hpkizi'] =  'HPKIZI';    
    $sources['mimo'] =  'Mimo HPKizi Universe';   
    $sources['efiction'] =  'Priamy cez efiction';
    $sources['chyba'] =  'Chyba';
                    
 	$output .= '<div class="form-group col-lg-4 col-md-4 col-sm-12">
					<label for="uid" class=" col-form-label">Zdroj:</label>
						<div>
						'.$frm->select('source', $sources, $source, array( 'class'=> 'custom-select-box', 'required' => 1)).'
						</div>
				</div>';               
                 
    $output .= '</div>';
 


    
  $output .= '<div class="alert alert-info" role="alert">
     Tu končia naše úpravy
        </div>';