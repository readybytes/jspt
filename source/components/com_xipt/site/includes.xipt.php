<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

if(defined('DEFINE_FRONT_INCLUDES'))
	return;

define('DEFINE_FRONT_INCLUDES','DEFINE_FRONT_INCLUDES');

// include JomSocial files
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
	return;
}

require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php';

// include xipt files
// common file to front and back
require_once JPATH_SITE.DS.'components'.DS.'com_xipt'.DS.'defines.xipt.php';

//front end files required
require_once JPATH_SITE.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'profiletypes.php';
require_once JPATH_SITE.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'acl.php';
require_once JPATH_SITE.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'core.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'pluginhandler.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'utils.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'apps.php';

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_xipt' );
	
/* Also attach style sheet now  */
/*
$document =& JFactory::getDocument();
$css	= JURI::base() . 'components/com_community/templates/default/css/jspt.css';
if($document)
	$document->addStyleSheet($css);
*/
