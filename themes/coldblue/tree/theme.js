/*
// $Id: theme.js,v 1.3 2004/12/16 02:51:19 draven_0 Exp $ 
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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
*/

// change this variable to update the theme directory
var ctThemeXPBase = 'images/tree/';

// theme node properties
var ctThemeXP =
{
	// tree attributes
	//
	// except themeLevel, all other attributes can be specified
	// for each level of depth of the tree.

  	// HTML code to the left of a folder item
  	// first one is for folder closed, second one is for folder opened
	folderLeft: [['<img alt="" src="' + ctThemeXPBase + 'folder2.gif" />', '<img alt="" src="' + ctThemeXPBase + 'folderopen2.gif" />']],
  	// HTML code to the right of a folder item
  	// first one is for folder closed, second one is for folder opened
  	folderRight: [['', '']],
	// HTML code for the connector
	// first one is for w/ having next sibling, second one is for no next sibling
	// then inside each, the first field is for closed folder form, and the second field is for open form
	folderConnect: [[['',''],['','']],[['<img alt="" src="' + ctThemeXPBase + 'plus.gif" />','<img alt="" src="' + ctThemeXPBase + 'minus.gif" />'],
					 ['<img alt="" src="' + ctThemeXPBase + 'plusbottom.gif" />','<img alt="" src="' + ctThemeXPBase + 'minusbottom.gif" />']]],

	// HTML code to the left of a regular item
	itemLeft: ['<img alt="" src="' + ctThemeXPBase + 'page.gif" />'],
	// HTML code to the right of a regular item
	itemRight: [''],
	// HTML code for the connector
	// first one is for w/ having next sibling, second one is for no next sibling
	itemConnect: [['',''],['<img alt="" src="' + ctThemeXPBase + 'join.gif" />', '<img alt="" src="' + ctThemeXPBase + 'joinbottom.gif" />']],

	// HTML code for spacers
	// first one connects next, second one doesn"t
	spacer: [['',''],['<img alt="" src="' + ctThemeXPBase + 'line.gif" />', '<img alt="" src="' + ctThemeXPBase + 'spacer.gif" />']],

	// deepest level of theme style sheet specified
	themeLevel: 1
};
