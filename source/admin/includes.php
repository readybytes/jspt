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

require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php';

// define our include paths to joomla
jimport( 'joomla.application.component.model' );
//JModel::addIncludePath(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models');
//JTable::addIncludePath( JPATH_ROOT.DS.'components'.DS.'com_xipt' . DS . 'tables' );

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_xipt' );
