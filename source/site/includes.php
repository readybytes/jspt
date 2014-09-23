<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

if(defined('DEFINE_FRONT_INCLUDES'))
	return;

define('DEFINE_FRONT_INCLUDES','DEFINE_FRONT_INCLUDES');

// include JomSocial files
jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.application.component.helper' );
//import JParameter for making joomla 1.6 compatible
jimport('joomla.html.parameter');
jimport('joomla.user.helper');
jimport('joomla.plugin.helper');

//if override file exists, then include it.
$override = JPATH_ROOT.'/components/com_xipt/defines.override.php';
if(JFile::exists($override))
	require_once JPATH_ROOT.'/components/com_xipt/defines.override.php';

// require_once defines.php
require_once JPATH_ROOT.'/components/com_xipt/defines.php';
require_once(XIPT_FRONT_PATH_LIBRARY.DS.'base'.DS.'loader.php');

/*Load Langauge file*/
JFactory::getLanguage()->load('com_xipt');
JFactory::getLanguage()->load('com_community');

//files required
XiptLoader::addAutoLoadViews(XIPT_FRONT_PATH_VIEWS, JRequest::getCmd('format','html'),	'Xipt');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_CONTROLLERS, 'Controller',	'Xipt');
XiptLoader::addAutoLoadFolder(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models','Model');
XiptLoader::addAutoLoadFolder(JPATH_ROOT.DS.'components'.DS.'com_xipt' . DS . 'tables','Table' );
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_HELPER,'Helper');


// auto load front libraries files
//XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY,'Library');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY_BASE,'');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY_LIB,'Lib');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY_ACL, 'Acl');
//rules should be autoloaded
XiptLoader::addAutoLoadACLRules(XIPT_FRONT_PATH_LIBRARY_ACL, 'Acl');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY_SETUP, 'Setup');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY_SETUP .DS. 'rule', 'SetupRule');

// autoloading for fileds
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY.DS.'fields'.DS.'templates', 'FieldsTemplates');
XiptLoader::addAutoLoadFolder(XIPT_FRONT_PATH_LIBRARY.DS.'fields'.DS.'profiletypes', 'FieldsProfiletypes');

// include JomSocial files
if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php'))
{
	$mainframe = JFactory::getApplication();
	$option=JRequest::getVar('option','','GET');
	if($option=='com_xipt'){
		$mainframe->redirect("index.php",XiptText::_("PLEASE_INSTALL_JOMSOCIAL"));
	}
	return false;
}

// Used default function of Js to auto load files. As CAssets won't get found in previously defined path. 
// Shows error in case of mod_latestmember module of Js 
require_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
spl_autoload_register('CFactory::autoload_libraries');

// auto load community classes
// XiptLoader::addAutoLoadFile('CFactory' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
// XiptLoader::addAutoLoadFile('CAssets' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
// XiptLoader::addAutoLoadFile('CConfig' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
// XiptLoader::addAutoLoadFile('CApplications' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
// XiptLoader::addAutoLoadFile('CUser' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
//XiptLoader::addAutoLoadFile('CRoute' , JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');

// Aotoloading for Jom social 2.0 [ Zend Plugin ]

$paths	= explode( PATH_SEPARATOR , get_include_path() );

if( !in_array( JPATH_ROOT . DS . 'plugins' . DS . 'system', $paths ) )
{
	set_include_path('.'
	    . PATH_SEPARATOR . JPATH_ROOT.DS.'plugins'.DS.'system'
	    . PATH_SEPARATOR . get_include_path()
	);
}
