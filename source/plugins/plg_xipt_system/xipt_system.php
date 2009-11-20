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
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');

class plgSystemxipt_system extends JPlugin
{
	var $_debugMode = 1;
	var $_eventPreText = 'event_';
		
	function plgSystemxipt_system( &$subject, $params )
	{
		parent::__construct( $subject, $params );
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');
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
		if($task=='BLANK')
			$task = JRequest::getCmd('task','BLANK','POST');
		
		switch(trim($option))
		{		 
		    case 'com_community':
		    case 'com_xipt':
		        break;
		        
		    default:
		           return;
		}
		
		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();

		if($option == 'com_community')
		{
			$nothing    = false;
			$pluginHandler->performACLCheck($nothing,$nothing,$nothing);
		}

		//do routine works
		$eventName = $this->_eventPreText.strtolower($option).'_'.strtolower($view).'_'.strtolower($task);
		
		//call defined event to handle work
		$exist = method_exists($pluginHandler,$eventName);
		if($exist)
		{
/*
 * We will store only where we need
 * 			//store current url into session
			XiPTLibraryUtils::setReturnURL();
*/			//call function
			$pluginHandler->$eventName();
		}
			
		return;
	}
}
