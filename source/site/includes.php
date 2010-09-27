<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

if(defined('DEFINE_FRONT_INCLUDES'))
	return;

define('DEFINE_FRONT_INCLUDES','DEFINE_FRONT_INCLUDES');

// include JomSocial files
jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.application.component.helper' );

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

// require_once defines.php
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'defines.php';

require_once(XIPT_FRONT_PATH_LIBRARY.DS.'base'.DS.'loader.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'includes.php');
//XICODREV : 


/*XITODO : Cleant IT Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_xipt' );

//files required
XiptLoader::addAutoLoadFolder(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models','Model');
XiptLoader::addAutoLoadFolder(JPATH_ROOT.DS.'components'.DS.'com_xipt' . DS . 'tables','Table' );
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_HELPER,'Helper');
	
// auto load community classes
require_once  JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php';
XiptLoader::addAutoLoadFile('CFactory' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiptLoader::addAutoLoadFile('CAssets' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiptLoader::addAutoLoadFile('CConfig' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiptLoader::addAutoLoadFile('CApplications' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiptLoader::addAutoLoadFile('CUser' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiptLoader::addAutoLoadFile('CRoute' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');

// auto load front libraries files
//XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY,'Library');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY_BASE,'');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY_LIB,'Lib');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY_ACL, 'Acl');


