<?php
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
	return;
}

require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php';

//admin files
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

// include xipt files
// common file to front and back
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'defines.xipt.php';

//front end files required
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'profiletypes.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'acl.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'core.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'pluginhandler.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'utils.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'apps.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'aec.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'imagegenerator.php';

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_xipt' );
