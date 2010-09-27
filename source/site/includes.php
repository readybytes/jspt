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

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'loader.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'includes.php');
//XICODREV : 
// require_once defines.php
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'defines.php';

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_xipt' );

//files required
XiPTLoader::addAutoLoadFolder(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models','Model');
XiPTLoader::addAutoLoadFolder(JPATH_ROOT.DS.'components'.DS.'com_xipt' . DS . 'tables','Table' );
XiPTLoader::addAutoLoadFolder(XIPT_FRONT_PATH_HELPER,'Helper');
XiPTLoader::addAutoLoadFile('XiFactory', XIPT_FRONT_PATH_HELPER.DS.'xiptcore.php');
	
