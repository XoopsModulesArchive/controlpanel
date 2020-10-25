<?php

if ( !defined('XOOPS_FOOTER_INCLUDED') ) {
    define('XOOPS_FOOTER_INCLUDED',1);

    $xoopsLogger->stopTime();

    if (0 == $xoopsOption['theme_use_smarty']) {
        // the old way

        $footer = $xoopsConfigMetaFooter['footer'] . '<br><div style="text-align:center">Powered by XOOPS &copy; 2002 <a href="https://www.xoops.org/" target="_blank">The XOOPS Project</a></div>';

        if (isset($xoopsOption['template_main'])) {
            $xoopsTpl->xoops_setCaching(0);

            $xoopsTpl->display('db:' . $xoopsOption['template_main']);
        }

        if (!isset($xoopsOption['show_rblock'])) {
            $xoopsOption['show_rblock'] = 0;
        }

        themefooter($xoopsOption['show_rblock'], $footer);

        xoops_footer();
    } else {
        // RMV-NOTIFY

        require_once XOOPS_ROOT_PATH . '/include/notification_select.php';

        if (isset($xoopsOption['template_main'])) {
            if (isset($xoopsCachedTemplateId)) {
                $xoopsTpl->assign('xoops_contents', $xoopsTpl->fetch('db:' . $xoopsOption['template_main'], $xoopsCachedTemplateId));
            } else {
                $xoopsTpl->assign('xoops_contents', $xoopsTpl->fetch('db:' . $xoopsOption['template_main']));
            }
        } else {
            if (isset($xoopsCachedTemplate)) {
                $xoopsTpl->assign('dummy_content', ob_get_contents());

                $xoopsTpl->assign('xoops_contents', $xoopsTpl->fetch($xoopsCachedTemplate, $xoopsCachedTemplateId));
            } else {
                $xoopsTpl->assign('xoops_contents', ob_get_contents());
            }

            ob_end_clean();
        }

        if (!headers_sent()) {
            header('Content-Type:text/html; charset=' . _CHARSET);

            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

            //header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');

            header('Cache-Control: private, no-cache');

            header('Pragma: no-cache');
        }

        $xoopsTpl->xoops_setCaching(0);

        $xoopsTpl->debug_tpl = 'db:' . $theme . '/debug_smarty.html';

        $xoopsTpl->display($xoopsConfig['theme_set'] . '/theme.html');
    }

    if ( $xoopsUserIsAdmin) {
        $dummyfile = 'dummy_' . time() . '.html';

        $fp = fopen(XOOPS_CACHE_PATH . '/' . $dummyfile, 'wb');

        $css = "<link rel='stylesheet' type='text/css' media='all' href='http://localhost/dev/modules/controlpanel/themes/" . $theme . "/debug.css'>";

        fwrite($fp, $css . $xoopsLogger->dumpAll());

        fclose($fp);

        echo '<script language=javascript>
		parent.parent.self.frames["debugger"].document.getElementById("mysqlframe").src = "' . XOOPS_URL . '/cache/' . $dummyfile . '";
		</script>';
    }
}

?>
