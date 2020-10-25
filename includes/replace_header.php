<?

 $mHandler = xoops_getHandler('module');
 $myModule =& $mHandler->getByDirname('controlpanel');
 $configHandler = xoops_getHandler('config');
 $ModuleConfig  = $configHandler->getConfigsByCat(0, $myModule->getVar('mid'));
 
 require_once XOOPS_ROOT_PATH.'/modules/controlpanel/includes/functions.php';
 require_once XOOPS_ROOT_PATH.'/modules/controlpanel/class/layerMenu.php';
  
 $theme     = $ModuleConfig['theme'];
 $module    = $myModule->getVar('dirname');
 $themedir  = XOOPS_URL.'/modules/'.$module.'/themes/'.$theme.'/';
 $themeLoc  = $themedir.'layermenu/';
 $lMenu     = new layerMenu($themeLoc,$module);
 $headers   = $lMenu->getHeaders();
 
 $css = "\n<link rel='stylesheet' type='text/css' href='".XOOPS_URL."/modules/".$myModule->getVar('dirname')."/themes/".$ModuleConfig['theme']."/bedit.css'>\n".$headers;

 
if ($xoopsConfig['theme_set'] != 'default' && file_exists(XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'].'/theme.php')) {
	// the old way..
	$xoopsOption['theme_use_smarty'] = 0;
	if (file_exists(XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'].'/language/lang-'.$xoopsConfig['language'].'.php')) {
		include XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'].'/language/lang-'.$xoopsConfig['language'].'.php';
	} elseif (file_exists(XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'].'/language/lang-english.php')) {
		include XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'].'/language/lang-english.php';
	}
	$configHandler = xoops_getHandler('config');
	$xoopsConfigMetaFooter = $configHandler->getConfigsByCat(XOOPS_CONF_METAFOOTER);
	xoops_header(false);
	include XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'].'/theme.php';
	$xoopsOption['show_rblock'] = (!empty($xoopsOption['show_rblock'])) ? $xoopsOption['show_rblock'] : 0;
	// include Smarty template engine and initialize it
	require_once XOOPS_ROOT_PATH.'/class/template.php';
	$xoopsTpl = new XoopsTpl();
	if ($xoopsConfig['debug_mode'] == 3) {
		$xoopsTpl->xoops_setDebugging(true);
	}
	if ($xoopsUser != '') {
		$xoopsTpl->assign(array('xoops_isuser' => true, 'xoops_userid' => $xoopsUser->getVar('uid'), 'xoops_uname' => $xoopsUser->getVar('uname'), 'xoops_isadmin' => $xoopsUserIsAdmin));
	}
	$xoopsTpl->assign('xoops_requesturi', htmlspecialchars($GLOBALS['xoopsRequestUri'], ENT_QUOTES));
	require XOOPS_ROOT_PATH.'/include/old_functions.php';
	
	if ($xoopsOption['show_cblock'] || (isset($xoopsModule) && preg_match("/index\.php$/i", xoops_getenv('PHP_SELF')) && $xoopsConfig['startpage'] == $xoopsModule->getVar('dirname'))) {
		$xoopsOption['show_rblock'] = $xoopsOption['show_cblock'] = 1;
	}
	themeheader($xoopsOption['show_rblock']);
	if ($xoopsOption['show_cblock']) make_cblock();  //create center block
} else {
	$xoopsOption['theme_use_smarty'] = 1;
	// include Smarty template engine and initialize it
	require_once XOOPS_ROOT_PATH.'/class/template.php';
	$xoopsTpl = new XoopsTpl();
	
	$xoopsTpl->assign('xoops_module_header', $css);
	 
	$xoopsTpl->xoops_setCaching(2);
	if ($xoopsConfig['debug_mode'] == 3) {
		$xoopsTpl->xoops_setDebugging(true);
	}
	
	if(!@$nodebug){
        $xoopsTpl->xoops_setDebugging(true);
    }

	$xoopsTpl->assign(array('xoops_theme' => $xoopsConfig['theme_set'], 'xoops_imageurl' => XOOPS_THEME_URL.'/'.$xoopsConfig['theme_set'].'/', 'xoops_themecss'=> xoops_getcss($xoopsConfig['theme_set']), 'xoops_requesturi' => htmlspecialchars($GLOBALS['xoopsRequestUri'], ENT_QUOTES), 'xoops_sitename' => htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES), 'xoops_slogan' => htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
	// Meta tags
	$configHandler = xoops_getHandler('config');
	$criteria = new CriteriaCompo(new Criteria('conf_modid', 0));
	$criteria->add(new Criteria('conf_catid', XOOPS_CONF_METAFOOTER));
	$config =& $configHandler->getConfigs($criteria, true);
	foreach (array_keys($config) as $i) {
		// prefix each tag with 'xoops_'
		$xoopsTpl->assign('xoops_'.$config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput());
	}
	//unset($config);
	// show banner?
	if ($xoopsConfig['banners'] == 1) {
		$xoopsTpl->assign('xoops_banner', xoops_getbanner());
	} else {
		$xoopsTpl->assign('xoops_banner', '&nbsp;');
	}
	// Weird, but need extra <script> tags for 2.0.x themes
	$xoopsTpl->assign('xoops_js', '//--></script><script type="text/javascript" src="'.XOOPS_URL.'/include/xoops.js"></script><script type="text/javascript"><!--');
	// get all blocks and assign to smarty
	$xoopsblock = new XoopsBlock();
	$block_arr = array();
	if ($xoopsUser != '') {
		$xoopsTpl->assign(array('xoops_isuser' => true, 'xoops_userid' => $xoopsUser->getVar('uid'), 'xoops_uname' => $xoopsUser->getVar('uname'), 'xoops_isadmin' => $xoopsUserIsAdmin));
		if (!empty($xoopsModule)) {
			// set page title
			$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name'));
			if (preg_match("/index\.php$/i", xoops_getenv('PHP_SELF')) && $xoopsConfig['startpage'] == $xoopsModule->getVar('dirname')) {
				$block_arr =& $xoopsblock->getAllByGroupModule($xoopsUser->getGroups(), $xoopsModule->getVar('mid'), true, XOOPS_BLOCK_VISIBLE);
			} else {
				$block_arr =& $xoopsblock->getAllByGroupModule($xoopsUser->getGroups(), $xoopsModule->getVar('mid'), false, XOOPS_BLOCK_VISIBLE);
			}
		} else {
			$xoopsTpl->assign('xoops_pagetitle', htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES));
			if (!empty($xoopsOption['show_cblock'])) {
				$block_arr =& $xoopsblock->getAllByGroupModule($xoopsUser->getGroups(), 0, true, XOOPS_BLOCK_VISIBLE);
			} else {
				$block_arr =& $xoopsblock->getAllByGroupModule($xoopsUser->getGroups(), 0, false, XOOPS_BLOCK_VISIBLE);
			}
		}
	} else {
		$xoopsTpl->assign(array('xoops_isuser' => false, 'xoops_isadmin' => false));
		if (isset($xoopsModule)) {
			// set page title
			$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name'));
			if (preg_match("/index\.php$/i", xoops_getenv('PHP_SELF')) && $xoopsConfig['startpage'] == $xoopsModule->getVar('dirname')) {
				$block_arr =& $xoopsblock->getAllByGroupModule(XOOPS_GROUP_ANONYMOUS, $xoopsModule->getVar('mid'), true, XOOPS_BLOCK_VISIBLE);
			} else {
				$block_arr =& $xoopsblock->getAllByGroupModule(XOOPS_GROUP_ANONYMOUS, $xoopsModule->getVar('mid'), false, XOOPS_BLOCK_VISIBLE);
			}
		} else {
			$xoopsTpl->assign('xoops_pagetitle', htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES));
			if (!empty($xoopsOption['show_cblock'])) {
				$block_arr =& $xoopsblock->getAllByGroupModule(XOOPS_GROUP_ANONYMOUS, 0, true, XOOPS_BLOCK_VISIBLE);
			} else {
				$block_arr =& $xoopsblock->getAllByGroupModule(XOOPS_GROUP_ANONYMOUS, 0, false, XOOPS_BLOCK_VISIBLE);
			}
		}
	}
	

	
	foreach (array_keys($block_arr) as $i) {
		$bcachetime = $block_arr[$i]->getVar('bcachetime');
		if (empty($bcachetime)) {
			$xoopsTpl->xoops_setCaching(0);
		} else {
			$xoopsTpl->xoops_setCaching(2);
			$xoopsTpl->xoops_setCacheTime($bcachetime);
		}
		$btpl = $block_arr[$i]->getVar('template');
		if ($btpl != '') {
			if (empty($bcachetime) || !$xoopsTpl->is_cached('db:'.$btpl)) {
				$xoopsLogger->addBlock($block_arr[$i]->getVar('name'));
				$bresult =& $block_arr[$i]->buildBlock();
				if (!$bresult) {
					continue;
				}
				$xoopsTpl->assign_by_ref('block', $bresult);
				$bcontent =& $xoopsTpl->fetch('db:'.$btpl);
				$xoopsTpl->clear_assign('block');
			} else {
				$xoopsLogger->addBlock($block_arr[$i]->getVar('name'), true, $bcachetime);
				$bcontent =& $xoopsTpl->fetch('db:'.$btpl);
			}
		} else {
			$bid = $block_arr[$i]->getVar('bid');
			if (empty($bcachetime) || !$xoopsTpl->is_cached('db:system_dummy.html', 'blk_'.$bid)) {
				$xoopsLogger->addBlock($block_arr[$i]->getVar('name'));
				$bresult =& $block_arr[$i]->buildBlock();
				if (!$bresult) {
					continue;
				}
				$xoopsTpl->assign_by_ref('dummy_content', $bresult['content']);
				$bcontent =& $xoopsTpl->fetch('db:system_dummy.html', 'blk_'.$bid);
				$xoopsTpl->clear_assign('block');
			} else {
				$xoopsLogger->addBlock($block_arr[$i]->getVar('name'), true, $bcachetime);
				$bcontent =& $xoopsTpl->fetch('db:system_dummy.html', 'blk_'.$bid);
			}
		}
		
		// block editing wrapper
		$bcontent = blockEditor(&$block_arr[$i], $bcontent,$lMenu);
		
		switch ($block_arr[$i]->getVar('side')) {
		case XOOPS_SIDEBLOCK_LEFT:
			$xoopsTpl->append('xoops_lblocks', array('title' => $block_arr[$i]->getVar('title'), 'content' => $bcontent));
			break;
		case XOOPS_CENTERBLOCK_LEFT:
			if (!isset($show_cblock)) {
				$xoopsTpl->assign('xoops_showcblock', 1);
				$show_cblock = 1;
			}
			$xoopsTpl->append('xoops_clblocks', array('title' => $block_arr[$i]->getVar('title'), 'content' => $bcontent));
			break;
		case XOOPS_CENTERBLOCK_RIGHT:
			if (!isset($show_cblock)) {
				$xoopsTpl->assign('xoops_showcblock', 1);
				$show_cblock = 1;
			}
			$xoopsTpl->append('xoops_crblocks', array('title' => $block_arr[$i]->getVar('title'), 'content' => $bcontent));
			break;
		case XOOPS_CENTERBLOCK_CENTER:
			if (!isset($show_cblock)) {
				$xoopsTpl->assign('xoops_showcblock', 1);
				$show_cblock = 1;
			}
			$xoopsTpl->append('xoops_ccblocks', array('title' => $block_arr[$i]->getVar('title'), 'content' => $bcontent));
			break;
		case XOOPS_SIDEBLOCK_RIGHT:
			if (!isset($show_rblock)) {
				$xoopsTpl->assign('xoops_showrblock', 1);
				$show_rblock = 1;
			}
			$xoopsTpl->append('xoops_rblocks', array('title' => $block_arr[$i]->getVar('title'), 'content' => $bcontent));
			break;
		}
		unset($bcontent);
	}
	
	//unset($block_arr);
	if (!isset($show_rblock)) {
		$xoopsTpl->assign('xoops_showrblock', 0);
	}
	if (!isset($show_cblock)) {
		$xoopsTpl->assign('xoops_showcblock', 0);
	}
	if (xoops_getenv('REQUEST_METHOD') != 'POST' && !empty($xoopsModule) && !empty($xoopsConfig['module_cache'][$xoopsModule->getVar('mid')])) {
		$xoopsTpl->xoops_setCaching(2);
		$xoopsTpl->xoops_setCacheTime($xoopsConfig['module_cache'][$xoopsModule->getVar('mid')]);
		if (!isset($xoopsOption['template_main'])) {
			$xoopsCachedTemplate = 'db:system_dummy.html';
		} else {
			$xoopsCachedTemplate = 'db:'.$xoopsOption['template_main'];
		}
		// generate safe cache Id
		$xoopsCachedTemplateId = 'mod_'.$xoopsModule->getVar('dirname').'|'.md5(str_replace(XOOPS_URL, '', $GLOBALS['xoopsRequestUri']));
		if ($xoopsTpl->is_cached($xoopsCachedTemplate, $xoopsCachedTemplateId)) {
			$xoopsLogger->addExtra($xoopsCachedTemplate, $xoopsConfig['module_cache'][$xoopsModule->getVar('mid')]);
			$xoopsTpl->assign('xoops_contents', $xoopsTpl->fetch($xoopsCachedTemplate, $xoopsCachedTemplateId));
			$xoopsTpl->xoops_setCaching(0);
			if (!headers_sent()) {
				header ('Content-Type:text/html; charset='._CHARSET);
			}
			$xoopsTpl->display($xoopsConfig['theme_set'].'/theme.html');
			if ($xoopsConfig['debug_mode'] == 2 && $xoopsUserIsAdmin) {
				$dummyfile = 'dummy_'.time().'.html';
				$fp = fopen(XOOPS_CACHE_PATH.'/'.$dummyfile, 'w');
				fwrite($fp, $xoopsLogger->dumpAll());
				fclose($fp);
				echo '<script language=javascript>
				debug_window = openWithSelfMain("'.XOOPS_URL.'/misc.php?action=showpopups&type=debug&file='.$dummyfile.'", "popup", 680, 450);
				</script>';
			}
			exit();
		}
	} else {
		$xoopsTpl->xoops_setCaching(0);
	}
	if (!isset($xoopsOption['template_main'])) {
		// new themes using Smarty does not have old functions that are required in old modules, so include them now
		require XOOPS_ROOT_PATH.'/include/old_theme_functions.php';
		// need this also
		$xoopsTheme['thename'] = $xoopsConfig['theme_set'];
		ob_start();
	}
}

?>