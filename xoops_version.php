<?php
// $Id: xoops_version.php,v 1.6 2004/12/20 23:01:27 draven_0 Exp $ 
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$modversion['name'] = _MI_CP_NAME;
$modversion['version'] = '0.1 Beta';
$modversion['description'] = _MI_CP_DESC;
$modversion['credits'] = "Jason Ibele (Draven)";
$modversion['author'] = "Jason Ibele";
$modversion['help'] = "not yet";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 1;
$modversion['image'] = "images/cp.png";
$modversion['dirname'] = "controlpanel";




// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Templates
$modversion['templates'][1]['file'] = 'coldblue/cp_main.html';
$modversion['templates'][1]['description'] = '';

$modversion['templates'][2]['file'] = 'coldblue/sidebar.html';
$modversion['templates'][2]['description'] = '';

$modversion['templates'][3]['file'] = 'coldblue/debug_smarty.html';
$modversion['templates'][3]['description'] = '';

$modversion['templates'][4]['file'] = 'coldblue/debug.html';
$modversion['templates'][4]['description'] = '';


// Menu
$modversion['hasMain'] = 1;
	
// Search
//$modversion['hasSearch'] = 0;

// Config
$modversion['config'][0]['name'] = 'default';         
$modversion['config'][0]['title'] = '_MI_CP_DEFAULT';
$modversion['config'][0]['description'] = '_MI_CP_DEFAULTDESC';
$modversion['config'][0]['formtype'] = 'yesno';
$modversion['config'][0]['valuetype'] = 'int';
$modversion['config'][0]['default'] = 0;

$modversion['config'][1]['name'] = 'theme';        
$modversion['config'][1]['title'] = '_MI_CP_THEME';
$modversion['config'][1]['description'] = '_MI_CP_THEMEDESC';
$myTopics = array();
$myTopics["Cold Blue"] = "coldblue";
$modversion['config'][1]['formtype'] = 'select';
$modversion['config'][1]['valuetype'] = 'string';
$modversion['config'][1]['default'] = 'coldblue';
$modversion['config'][1]['options'] = $myTopics;

$modversion['config'][2]['name'] = 'sidewidth';         
$modversion['config'][2]['title'] = '_MI_CP_SIDEBARW';
$modversion['config'][2]['description'] = '_MI_CP_SIDEBARWDESC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 230;

$modversion['config'][3]['name'] = 'debugheight';         
$modversion['config'][3]['title'] = '_MI_CP_DEBUGH';
$modversion['config'][3]['description'] = '_MI_CP_DEBUGHDESC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 230;
?>