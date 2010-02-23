<?php 
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
	return;
}
require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php';


// common file to front and back
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'defines.xipt.php';

//// define our include paths to joomla
jimport( 'joomla.application.component.model' );
JModel::addIncludePath(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'models');
JTable::addIncludePath( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt' . DS . 'tables' );

//front end files required
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'profiletypes.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'aec.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'imagegenerator.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'utils.php';

//bakcend files required
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profiletypes.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'xiptcore.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'applications.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profilefields.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'aclrules.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'setup.php';

require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'aclrules'.DS.'aclrule.php';

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_xipt' );
