<?php
/**
 *
 * Author : Team Joomlaxi
 * Email  : shyam@joomlaxi.com
 * (C) www.joomlaxi.com
 *
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// include joomla plugin framework
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
	return;

if(JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php'))
	require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

class plgCommunityxipt_community extends CApplications
{
	private $_pluginHandler;
	
	function plgCommunityxipt_community( &$subject, $params )
	{
		parent::__construct( $subject, $params );
		$this->_pluginHandler = XiPTFactory::getLibraryPluginHandler();
	}
	
	function onProfileCreate(&$cuser)
	{
		$this->_pluginHandler->onProfileCreate($cuser);
	}
	
	
	function onProfileAvatarUpdate(&$userid, &$old_avatar_path, &$new_avatar_path)
	{
	    $this->_pluginHandler->onProfileAvatarUpdate($userid, $old_avatar_path, $new_avatar_path);
	}

	function onAjaxCall(&$func, &$args , &$response)
	{
		return $this->_pluginHandler->onAjaxCall($func, $args, $response);
	}

	// update the configuration
	function onAfterConfigCreate($config)
	{
		return $this->_pluginHandler->onAfterConfigCreate($config);
	}

	function onAfterAppsLoad()
	{
        return $this->_pluginHandler->onAfterAppsLoad();
	}


	function onBeforeProfileUpdate(&$userId, &$fieldValues)
	{
		return $this->_pluginHandler->onBeforeProfileUpdate($userId, $fieldValues);
	}
	
	function onAfterProfileUpdate(&$userId, &$saveSuccess)
	{
		return $this->_pluginHandler->onAfterProfileUpdate($userId, $saveSuccess);
	}
}
