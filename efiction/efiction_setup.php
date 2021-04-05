<?php

// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
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

/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 efiction Plugin
 *
 * #######################################
 * #     e107 website system plugin      #
 * #     by Jimako                    	 #
 * #     https://www.e107sk.com          #
 * #######################################
 */

e107::lan('efiction', true, true);

if (!class_exists('efiction_setup')) {
    class efiction_setup
    {
        public function install_pre($var)
        {
            // print_a($var);
            // echo "custom install 'pre' function<br /><br />";
        }

        /**
         * For inserting default database content during install after table has been created by the efiction_sql.php file.
         */
        public function install_post($var)
        {
            $ret = e107::getXml(true)->e107Import(e_PLUGIN.'efiction/xml/install.xml');

            if (!empty($ret['success'])) {
                e107::getMessage()->addSuccess(LAN_EFICTION_ADMIN_001);
            }

            if (!empty($ret['failed'])) {
                e107::getMessage()->addError(LAN_EFICTION_ADMIN_002);
                e107::getMessage()->addDebug(print_a($ret['failed'], true));
            }
        }

        public function uninstall_options()
        {
            /*$listoptions = array(0=>'option 1',1=>'option 2');

            $options = array();
            $options['mypref'] = array(
                    'label'		=> 'Custom Uninstall Label',
                    'preview'	=> 'Preview Area',
                    'helpText'	=> 'Custom Help Text',
                    'itemList'	=> $listoptions,
                    'itemDefault'	=> 1
            );

            return $options;*/
        }

        public function uninstall_post($var)
        {
            // print_a($var);
        }

        public function upgrade_post($var)
        {
            // $sql = e107::getDb();
        }
    }
}
