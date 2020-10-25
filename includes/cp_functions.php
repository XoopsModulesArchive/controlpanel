<?php
// $Id: cp_functions.php,v 1.2 2004/12/20 23:59:46 draven_0 Exp $
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
$mHandler = xoops_getHandler('module');
$myModule = &$mHandler->getByDirname('controlpanel');
$configHandler = xoops_getHandler('config');
$ModuleConfig = $configHandler->getConfigsByCat(0, $myModule->getVar('mid'));

$path = XOOPS_URL . '/modules/' . $myModule->getVar('dirname') . '/themes/' . $ModuleConfig['theme'] . '/admin.css';

function xoops_cp_header()
{
    global $xoopsConfig, $xoopsUser, $path;

    if (1 == $xoopsConfig['gzip_compression']) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    }

    if (!headers_sent()) {
        header ('Content-Type:text/html; charset=' . _CHARSET);

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

        header('Cache-Control: no-store, no-cache, must-revalidate');

        header('Cache-Control: post-check=0, pre-check=0', false);

        header('Pragma: no-cache');
    }

    echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="' . _LANGCODE . '" lang="' . _LANGCODE . '">
	<head>
	<meta http-equiv="content-type" content="text/html; charset=' . _CHARSET . '">
	<meta http-equiv="content-language" content="' . _LANGCODE . '">
	<title>' . htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES) . ' Administration</title>
	<script type="text/javascript" src="' . XOOPS_URL . '/include/xoops.js"></script>
	';

    echo '<link rel="stylesheet" type="text/css" media="all" href="' . XOOPS_URL . '/xoops.css">';

    echo '<link rel="stylesheet" type="text/css" media="all" href="' . XOOPS_URL . '/modules/system/style.css">';

    echo '<link rel="stylesheet" type="text/css" media="all" href="' . $path . '">';

    $modulepermHandler = xoops_getHandler('groupperm');

    $admin_mids = &$modulepermHandler->getItemIds('module_admin', $xoopsUser->getGroups());  

    $logo = file_exists(XOOPS_THEME_URL . '/' . getTheme() . '/images/logo.gif') ? XOOPS_THEME_URL . '/' . getTheme() . '/images/logo.gif' : XOOPS_URL . '/images/logo.gif';

    echo '</head>
      <body>';
}

function xoops_cp_footer()
{
    global $xoopsConfig, $xoopsLogger,$xoopsUserIsAdmin,$ModuleConfig;

    echo'
        </body>
      </html>
    ';

    if ( $xoopsUserIsAdmin) {
        $dummyfile = 'dummy_' . time() . '.html';

        $fp = fopen(XOOPS_CACHE_PATH . '/' . $dummyfile, 'wb');

        $css = "<link rel='stylesheet' type='text/css' media='all' href='http://localhost/dev/modules/controlpanel/themes/" . $ModuleConfig['theme'] . "/debug.css'>";

        fwrite($fp, $css . $xoopsLogger->dumpAll());

        fclose($fp);

        echo '<script language=javascript>
		parent.parent.self.frames["debugger"].document.getElementById("mysqlframe").src = "' . XOOPS_URL . '/cache/' . $dummyfile . '";
		</script>';
    }

    ob_end_flush();
}

function xoops_module_write_admin_menu()
{
}

function xoops_module_get_admin_menu()
{
}
?>
