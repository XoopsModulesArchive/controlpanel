<?php
// $Id: treemenu.php,v 1.4 2004/12/16 10:32:40 draven_0 Exp $ 
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

class treeMenu
{
    public $_themeLoc;

    public $_module;

    public $debug;

    public $menuDef;

    public function treeMenu ($themeLoc, $module, $debug = false)
    {
        $this->_themeLoc = $themeLoc;

        $this->_module = $module;

        $this->debug = $debug;
    }

    public function getHeaders()
    {
        $head = "<SCRIPT src='" . XOOPS_URL . '/modules/' . $this->_module . "/js_files/JSCookTree.js' type=text/javascript></SCRIPT>\n";

        $head .= "<LINK href='" . $this->_themeLoc . "theme.css' type=text/css rel=stylesheet>\n";

        $head .= "<SCRIPT src='" . $this->_themeLoc . "theme.js' type=text/javascript></SCRIPT>\n";

        return $head;
    }

    public function buildTree ($menuarray, $menuName)
    {
        $menu = '';

        if (!$this->debug) {
            $menu .= "\n<SCRIPT type=text/javascript>\n";
        }

        $menu .= "var $menuName = \n[";

        if (is_array($menuarray)) {
            foreach ($menuarray as $mainitem) {
                $menu .= $this->doMain($mainitem);
            }
        }

        $menu .= "\n];\n</SCRIPT>";

        $this->menuDef = $menu;
    }

    public function getMenu($menuarray, $menuName, $treeTheme, $hideType = 0, $expandLevel = 0)
    {
        $this->buildTree($menuarray,$menuName);

        // Our blank div tag which the menu is generated in

        $divtag = "<div style='display:none'>.</div>\n<div id='$menuName'></div>";

        // JS function to draw the menu

        $draw = "\n<SCRIPT type=text/javascript><!-- \n ctDraw ('$menuName', $menuName, $treeTheme, '$treeTheme', $hideType, $expandLevel);\n --></SCRIPT>";

        if (true === $this->debug) {
            echo "<pre>\nCLASS OBJECT VARS:\n\n";

            print_r($this);

            echo '</pre>';
        } else {
            return $divtag . $this->menuDef . $draw;
        }
    }

    public function doMain($mainitem,$child = FALSE,$t = "\t")
    {
        // Setup the javascript structure components for building the tree menu definitions

        $nline = "\n";

        $menu = '';

        $begin = '[';

        $div = ',';

        $endm = '],';

        // check if this item is a new menu

        if (is_array($mainitem[0])) {
            $items = $this->format($mainitem[0],TRUE);

            // constartuct the JS entry

            $menu .= $nline . 
                        $t .
                        $begin .
                        $items[0] . // img slot
                        $div .
                        $items[1] . // Text
                        $div .
                        $items[2] . // URL
                        $div .
                        $items[3] . // Extra
                        $div .
                        $items[4] . // Title tage
                        $div;

            // Get the child menu items         

            $menu .= $this->doChildren($mainitem,$t);

            $menu .= $nline . $t . $endm;

        // Otherwise just a plain link
        } else {
            $ismain = ($child) ? FALSE : TRUE;

            $mainitem = $this->format($mainitem, $ismain);

            // constartuct the JS entry

            if (count($mainitem) > 2) {
                $menu .= $nline .
                            $t .
                            $begin .
                            $mainitem[0] . // img slot
                            $div .
                            $mainitem[1] . // Text                       
                            $div .
                            $mainitem[2] . // URL
                            $div .
                            $mainitem[3] . // Extra
                            $div .
                            $mainitem[4] . // Title tage
                            $endm;
            } else {
                $menu .= $nline .
                            $t .
                            $begin .
                            $mainitem[0] . // _cmNoAction
                            $div .
                            $mainitem[1] . // HTML                       
                            $endm;
            }
        }

        return $menu;
    }

    public function doChildren($childItems,$t)
    {
        $t = $t . "\t"; // tabs - add one tab for each time this is called for indenting

        $menu = '';

        for ($i = 1; $i != count($childItems); $i++) {
            $menu .= $this->doMain($childItems[$i],TRUE,$t);
        }

        return $menu;
    }

    public function format($items,$main = false)
    {
        // was an image included?

        if ($items[0]) {
            if (count($items) > 2) {
                $item[0] = "'" . $items[0] . "'";
            } else {
                $item[0] = $items[0];
            }
        } else {
            $item[0] = 'null';
        }

        // format title with single quotes

        if ($items[1]) {
            if (count($items) > 2) {
                $item[1] = ($main) ? "'<b>" . $items[1] . "</b> '" : "'" . $items[1] . " '";
            } else {
                $item[1] = '"' . $items[1] . '"';
            }
        } else {
            $item[1] = 'null';
        }

        if (count($items) > 2) {
            // check for a link supplied

            if ($items[2]) {
                $item[2] = "'" . $items[2] . "'";
            } else {
                $item[2] = 'null';
            }

            // check for extras

            if ($items[3]) {
                $item[3] = "'" . $items[3] . "'";
            } else {
                $item[3] = 'null';
            }

            // check for title (title tag value)

            if ($items[4]) {
                $item[4] = "'" . $items[4] . "'";
            } else {
                $item[4] = 'null';
            }
        }

        return $item;
    }
}

?>
