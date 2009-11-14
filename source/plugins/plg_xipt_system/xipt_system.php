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


require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');

class plgSystemxipt_system extends JPlugin
{
	var $_debugMode = 1;
	var $_eventPreText = 'event_';
		
	function plgSystemxipt_system( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	
	function onAfterRoute()
	{
 		global $mainframe;
		
		// Dont run in admin
		if ($mainframe->isAdmin())
			return;
		
		$option = JRequest::getCmd('option','','GET');
		$view = JRequest::getCmd('view','BLANK','GET');
		$task = JRequest::getCmd('task','BLANK','GET');
		
		if(trim($option) == 'com_community')
			XiPTLibraryAcl::performACLCheck(0,0,0);
		
		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
		
		$eventName = $this->_eventPreText.strtolower($option).'_'.strtolower($view).'_'.strtolower($task);
		
		//call defined event to handle work
		$exist = method_exists($pluginHandler,$eventName);
		if($exist)
		{
			//store current url into session
			$mySess =& JFactory::getSession();
			$mySess->set('RETURL', $this->_getCurrentURL(),'XIPT');
			//call function
			$pluginHandler->$eventName();
		}
			
		
		//$eventName .= '()';
		//$pluginHandler->$eventName();
		return;
		//JPlugin::loadLanguage( 'plg_xipt_redirector', JPATH_ADMINISTRATOR );
	}
	
	
	// decode the return URL, so that we can return to proper address.
	function _getCurrentURL()
	{
		// TO DO : Get url
		$url = JFactory::getURI()->toString( array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment'));
		return base64_encode($url);
	}
}
