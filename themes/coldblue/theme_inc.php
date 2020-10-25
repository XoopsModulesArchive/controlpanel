<?php
// $Id: theme_inc.php,v 1.2 2004/12/20 23:59:47 draven_0 Exp $
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




 switch($section){
    
    case('main'):

         require __DIR__ . '/layermenu.php';
         $GLOBALS['xoopsOption']['template_main'] = $xoopsModuleConfig['theme'].'/cp_main.html';
         $css = "\n<link rel='stylesheet' type='text/css' href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/themes/".$xoopsModuleConfig['theme']."/style.css'>";
         $xoopsTpl->assign('xoops_module_header', $headers.$css);
         $xoopsTpl->assign('treemenu', 'treemenu');
         $xoopsTpl->assign('sidebar', $xoopsModuleConfig['sidewidth']);         
         $xoopsTpl->assign('debug', $xoopsModuleConfig['debugheight']);
         
    break;
    
    case('sidebar'):
    
         $GLOBALS['xoopsOption']['template_main'] = $xoopsModuleConfig['theme'].'/sidebar.html';
         $css = "\n<link rel='stylesheet' type='text/css' href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/themes/".$xoopsModuleConfig['theme']."/style.css'>";
         $xoopsTpl->assign('xoops_module_header', $css);
    
    break;
    
    case('debug'):
        
         $css = '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/themes/'.$xoopsModuleConfig['theme'].'/debug.css">';
         $GLOBALS['xoopsOption']['template_main'] = $xoopsModuleConfig['theme'].'/debug.html';
         $xoopsTpl->assign('xoops_module_header', $css);
    
    break;
    
    
    
 }
?>