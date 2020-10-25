<?php
// $Id: functions.php,v 1.2 2004/12/20 23:59:46 draven_0 Exp $ 
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

 @require_once dirname(__DIR__, 2) . '/mainfile.php';

 function getModuleTree()
 {
     $cnt = 1;

     $moduleHandler = xoops_getHandler('module');

     $criteria = new CriteriaCompo();

     $criteria->add(new Criteria('hasadmin', 1));

     $criteria->add(new Criteria('isactive', 1));

     $criteria->setSort('mid');

     $mods = $moduleHandler->getObjects($criteria);

     foreach ($mods as $mod) {
         $cnt = 0;

         $modid = $mod->getVar('mid');

         $tree[$modid][$cnt][4] = "<img src='" . XOOPS_URL . '/modules/' . $mod->getVar('dirname') . '/' . $mod->getInfo('image') . "' alt=''>";

         $tree[$modid][$cnt][1] = $mod->getVar('name');

         $tree[$modid][$cnt][2] = XOOPS_URL . '/modules/' . $mod->getVar('dirname') . '/' . trim($mod->getInfo('adminindex'));

         $tree[$modid][$cnt][3] = $modid;

         $tree[$modid][$cnt][5] = '<b>' . _VERSION . ':</b> ' . round($mod->getVar('version') / 100 , 2) . '<br><b>' . _DESCRIPTION . ':</b> ' . $mod->getInfo('description');

         $layer_label[$cnt] = 'L' . $cnt;

         $cnt++;

         $adminmenu = $mod->getAdminMenu();

         if ($mod->getVar('hasnotification') || ($mod->getInfo('config') && is_array($mod->getInfo('config'))) || ($mod->getInfo('comments') && is_array($mod->getInfo('comments')))) {
             $adminmenu[] = ['link' => XOOPS_URL . '/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $modid, 'title' => _PREFERENCES, 'absolute' => true];
         }

         if (!empty($adminmenu)) {
             foreach ( $adminmenu as $menuitem ) {
                 $menuitem['link'] = trim($menuitem['link']);

                 $menuitem['target'] = isset($menuitem['target']) ? trim($menuitem['target']) : '';

                 $tree[$modid][$cnt][1] = trim($menuitem['title']);

                 if (isset($menuitem['absolute']) && $menuitem['absolute']) {
                     $tree[$modid][$cnt][2] = (empty($menuitem['link'])) ? '#' : $menuitem['link'];
                 } else {
                     $tree[$modid][$cnt][2] = (empty($menuitem['link'])) ? '#' : XOOPS_URL . '/modules/' . $mod->getVar('dirname') . '/' . $menuitem['link'];
                 }

                 $tree[$modid][$cnt][3] = $modid;

                 $cnt++;
             }
         }
     }

     return $tree;
 }

 function blockEditor($block_arr, $content,$lMenu)
 {
     global $ModuleConfig;

     //print_r($block_arr->getVar('bid'));

     $block = "<div  class='bedit'><div style='background-image: url(" . XOOPS_URL . '/modules/controlpanel/themes/' . $ModuleConfig['theme'] . "/images/beditor/bedit_bg.png);'>";

     $block .= "<div class='right'>";

     $block .= "<img src='" . XOOPS_URL . '/modules/controlpanel/themes/' . $ModuleConfig['theme'] . "/images/beditor/bedit_pref.png'>";

     $block .= "<img src='" . XOOPS_URL . '/modules/controlpanel/themes/' . $ModuleConfig['theme'] . "/images/beditor/bedit_col.png'>";

     $block .= "<img src='" . XOOPS_URL . '/modules/controlpanel/themes/' . $ModuleConfig['theme'] . "/images/beditor/bedit_r.png'>";

     $block .= '</div>';

     $block .= "<div class='left'>";

     $block .= "<img src='" . XOOPS_URL . '/modules/controlpanel/themes/' . $ModuleConfig['theme'] . "/images/beditor/bedit_l.png'>";

     $block .= "<img src='" . XOOPS_URL . '/modules/controlpanel/themes/' . $ModuleConfig['theme'] . "/images/beditor/bedit_up.png'>";

     $block .= "<img src='" . XOOPS_URL . '/modules/controlpanel/themes/' . $ModuleConfig['theme'] . "/images/beditor/bedit_dn.png'>";

     $block .= '</div>';

     $block .= "<div align='center'>";

     $block .= "<img src='" . XOOPS_URL . '/modules/controlpanel/themes/' . $ModuleConfig['theme'] . "/images/beditor/bedit_logo.png' align='center'>";

     $block .= '</div>';

     $block .= '</div></div>';

     $block .= $content;

     return $block;
 }

?>
