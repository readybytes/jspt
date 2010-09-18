<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

if(defined('DEFINE_ADMIN_INCLUDES'))
	return;

define('DEFINE_ADMIN_INCLUDES','DEFINE_ADMIN_INCLUDES');

//	This is file for BACKEND only, should be included in starting file only.

jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );

// include JomSocial files
if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_community'))
{
	global $mainframe;
	$option=JRequest::getVar('option','','GET');
	if($option=='com_xipt'){
		$mainframe->redirect("index.php",JText::_("PLEASE INSTALL JOMSOCIAL"));
	}
	return false;
}

// require loader.php of xipt backend
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'loader.php');

// auto load community classes
require_once  JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php';
XiPTLoader::addAutoLoadFile('CFactory' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiPTLoader::addAutoLoadFile('CAssets' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiPTLoader::addAutoLoadFile('CConfig' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiPTLoader::addAutoLoadFile('CApplications' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiPTLoader::addAutoLoadFile('CUser' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiPTLoader::addAutoLoadFile('CRoute' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');



// common file to front and back
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'defines.xipt.php';

// define our include paths to joomla
jimport( 'joomla.application.component.model' );
JModel::addIncludePath(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'models');
JTable::addIncludePath( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt' . DS . 'tables' );

//bakcend helper files required
XiPTLoader::addAutoLoadFolder(XIPT_ADMIN_PATH_HELPER,'Helper');
XiPTLoader::addAutoLoadFile('XiPTHelperAclRules', XIPT_ADMIN_PATH_HELPER.DS.'aclrules.php');
XiPTLoader::addAutoLoadFile('XiPTHelperProfileFields', XIPT_ADMIN_PATH_HELPER.DS.'profilefields.php');
XiPTLoader::addAutoLoadFile('XiFactory', XIPT_ADMIN_PATH_HELPER.DS.'xiptcore.php');

// auto load front libraries files
XiPTLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY,'Library');
XiPTLoader::addAutoLoadFile('XiPTFactory', JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'core.php');
XiPTLoader::addAutoLoadFile('XiPTLibraryCore', JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'core.php');
XiPTLoader::addAutoLoadFile('XiPTImageGenerator',JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'imagegenerator.php');
XiPTLoader::addAutoLoadFile('XiPTRoute',JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'route.php');

// libray file of backend
XiPTLoader::addAutoLoadFile('aclFactory',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'aclrules'.DS.'aclrule.php');
XiPTLoader::addAutoLoadFile('xiptAclRules',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'aclrules'.DS.'aclrule.php');

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_xipt' );
