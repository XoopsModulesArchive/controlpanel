<?php
// $Id: layermenu.php,v 1.1 2004/12/19 05:17:48 draven_0 Exp $
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

 require_once dirname(__DIR__, 2) . '/mainfile.php';
 require_once __DIR__ . '/includes/functions.php';
 
 // Language files
 require XOOPS_ROOT_PATH.'/modules/system/language/'.$xoopsConfig['language'].'/modinfo.php';
 require XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/language/'.$xoopsConfig['language'].'/cpanel.php';
 require XOOPS_ROOT_PATH.'/modules/system/menu.php';
 
 // include the tree class
 require_once __DIR__ . '/class/layerMenu.php';

 // Setup options for reuse (just makes for nicer looking code
 $theme     = $xoopsModuleConfig['theme'];
 $module    = $xoopsModule->getVar('dirname');
 $sysflder  = XOOPS_URL.'/modules/system/';
 $sysadmin  = $sysflder.'admin.php?fct=preferences&op=show&confcat_id=';
 $themedir  = XOOPS_URL.'/modules/'.$module.'/themes/'.$theme.'/';
 
 // Configs for tree menu
 $themeLoc  = $themedir.'layermenu/';                         	// location of the themes.js and theme.css
 $imageLoc  = $themedir.'images/layermenu/';                  	// location of the images supplied in the images input
 $link      = "javascript:;";                                 	// Now link needed, using onclick event
 $menuTheme = "cmThemeOffice";                                	// this is the name of the theme given in the theme.js file
 $menuName  = "layermenu";                                    	// Div ID name for your menu (can be anything)

 // Load the Tree Class with configs
 $lMenu    = new layerMenu($themeLoc,$module);
 
 // A little custom function to reduce code 
  function doURL($url){
     return "onclick=\'doURL(\"".$url."\")\'";
 }
  
 // a function to simplify the formatting for a rollover image
 function rollover($up, $dn){
  	global $imageLoc;
  	
    $cssup = 'seq1';
    $cssdn = 'seq2';
  	                      
    $img1 = '<img src="'.$imageLoc.'/'.$up.'" class="'.$cssup.'" align="absmiddle">';
  	$img2 = '<img src="'.$imageLoc.'/'.$dn.'" class="'.$cssdn.'" align="absmiddle">';
  	
    return $img1.$img2;
 }
  
 
 /*************************************************************************************************
  *                                 MENU ARRAY HIERCHY                                            *
  *                                                                                               *
  *  The class needs an array hierchy to build the menu from, how you build the array determines  *
  *  the outcome.                                                                                 *
  *                                                                                               *
  *  New Item: array( IMG, TEXT, URL, EXTRA (within <A> tag), TITLE);                             *
  *                                                                                               *
  *  Each array level designates a new folder/Main Item in the hierchy. See below for example.    *
  *                                                                                               *
  ************************************************************************************************/
 // ----------------------------  build menu items array ----------------------------------------//

 $array[][] = array(rollOver("pref_up.png","pref_dn.png"), $adminmenu[5]["title"].'<img src="'.$imageLoc.'arrow_dn.png" align="absbottom">', '', '', $adminmenu[5]["title"]);
     $array[0][] = array('<img src="'.$imageLoc.'pref.png">',      _CP_AM_GENERAL,      $link, doURL($sysadmin.'1'), _CP_AM_GENERAL);
     $array[0][] = array('<img src="'.$imageLoc.'users.png">',     _CP_AM_USERSETTINGS, $link, doURL($sysadmin.'2'), _CP_AM_USERSETTINGS);
     $array[0][] = array('<img src="'.$imageLoc.'pref_edit.png">', _CP_AM_METAFOOTER,   $link, doURL($sysadmin.'3'), _CP_AM_METAFOOTER);
     $array[0][] = "_cmSplit,";
     $array[0][] = array('<img src="'.$imageLoc.'censor.png">',    _CP_AM_CENSOR,       $link, doURL($sysadmin.'4'), _CP_AM_CENSOR);
     $array[0][] = array('<img src="'.$imageLoc.'search.png">',    _CP_AM_SEARCH,       $link, doURL($sysadmin.'5'), _CP_AM_SEARCH); 
     $array[0][] = array('<img src="'.$imageLoc.'mail.png">',      _CP_AM_MAILER,       $link, doURL($sysadmin.'6'), _CP_AM_MAILER);
 $array[1] = "_cmSplit,";
 $array[2][] = array(rollOver("user_up.png","user_dn.png"), 'User Management<img src="'.$imageLoc.'arrow_dn.png" align="absbottom">', '', '', 'User Management');
     $array[2][] = array('<img src="'.$imageLoc.'search.png">',   $adminmenu[9]["title"],  $link, doURL($sysflder.$adminmenu[9]["link"]),  $adminmenu[9]["title"]);
     $array[2][] = array('<img src="'.$imageLoc.'user.png">',   $adminmenu[8]["title"],  $link, doURL($sysflder.$adminmenu[8]["link"]),  $adminmenu[8]["title"]);
     $array[2][] = array('<img src="'.$imageLoc.'users.png">',  $adminmenu[2]["title"],  $link, doURL($sysflder.$adminmenu[2]["link"]),  $adminmenu[2]["title"]);
     $array[2][] = array('<img src="'.$imageLoc.'mail.png">',   $adminmenu[10]["title"], $link, doURL($sysflder.$adminmenu[10]["link"]), $adminmenu[10]["title"]);
     $array[2][] = array('<img src="'.$imageLoc.'rank.png">',   $adminmenu[7]["title"],  $link, doURL($sysflder.$adminmenu[7]["link"]),  $adminmenu[7]["title"]);      
 $array[5] = "_cmSplit,";
 $array[6][] = array(rollOver("block_up.png","block_dn.png"), 'Blocks<img src="'.$imageLoc.'arrow_dn.png" align="absbottom">', '', '', 'User Management');
 $array[7] = "_cmSplit,";

 // do modules   
 $array[8][] = array(rollOver("modules_up.png","modules_dn.png"), 'Modules<img src="'.$imageLoc.'arrow_dn.png" align="absbottom">', '', '', 'Modules'); 
 $tree = getModuleTree();
 $mcount=2;
 foreach($tree as $mid=>$module){
    if($mid != 1){
       $array[8][$mcount][0] = array('', $module[0][1], $link, '', $module[0][1]);
       for($i=1;$i < count($module); $i++){
             
             $array[8][$mcount][$i] = array('', $module[$i][1], $link, doURL($module[$i][2]), $module[$i][1]);
       }
       $array[8][$mcount][$i++] = array('_cmNoAction', "<td colspan=3 class='cmThemeOfficeMenuModVersion'>".$module[0][4]."</td>");
    }else{
        $array[8][] = array('', 'Module Admin', $link, doURL('http://localhost/dev/modules/system/admin.php?fct=modulesadmin'), 'Module Admin');
        $array[8][] = "_cmSplit,";
    }
    $mcount++;   
 }

 $array[9] = "_cmSplit,";
 $array[10][] = array(rollOver("media_up.png","media_dn.png"), 'Media Files<img src="'.$imageLoc.'arrow_dn.png" align="absbottom">', '', '', 'Media Files');
 
              	                  	                  	
  // ---------------------------------------  end ---------------------------------------------//    
     


 $headers = $lMenu->getHeaders();
 $menu    = $lMenu->getMenu($array, $menuName, $menuTheme, 'hbr'); // hbr = horizontal bar that drops down to the bottom right

 $headers .= "
 <script language='javascript'> 
 function doURL(newURL) 
 { 
    var target = 'mainframe';
    parent.document.getElementById(target).src = newURL;
 }
 </script>\n\n";
      
 //echo $headers;
 //echo $menu;
 
 $xoopsTpl->assign('menu', $menu);
 

?>