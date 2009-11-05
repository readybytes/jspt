<?php 
// no direct access
defined('_JEXEC') or die('Restricted access');

//	This is file for BACKEND only, should be included in starting file only.

// include JomSocial files
require_once JPATH_SITE.DS.'components'.DS.'com_community'.DS.'defines.community.php';
require_once JPATH_SITE.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php';


// common file to front and back
require_once JPATH_SITE.DS.'components'.DS.'com_xipt'.DS.'defines.xipt.php';

//// define our include paths to joomla
JModel::addIncludePath(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'models');
JTable::addIncludePath( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt' . DS . 'tables' );

//front end files required
require_once JPATH_SITE.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'profiletypes.php';

//bakcend files required
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profiletypes.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'xiptcore.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'applications.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profilefields.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'aclrules.php';