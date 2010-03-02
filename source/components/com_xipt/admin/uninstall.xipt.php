<?php
// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.folder' );
jimport('joomla.filesystem.file');


require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'helpers' .DS. 'unhook.php';

function com_uninstall()
{
	XiPTHelperUnhook::uncopyHackedFiles();
	// disable plugins
	XiPTHelperUnhook::disable_plugin('xipt_system');
	XiPTHelperUnhook::disable_plugin('xipt_plugin');
	
	XiPTHelperUnhook::disable_custom_fields();
	//insert configuration data into new table
	//to preserve user global configuration settings
	XiPTHelperUnhook::store_globalconfiguration();
}

