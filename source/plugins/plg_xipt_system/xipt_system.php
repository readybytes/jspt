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
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
	return;

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
		
		if(JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php'))
			require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

		//sometimes in SEF, value from GET might be blank		
		$option = JRequest::getCmd('option','BLANK','GET');
		if($option == 'BLANK')
			$option = JRequest::getVar('option','');

		//sometimes in SEF, value from GET might be blank
		$task = JRequest::getCmd('task','BLANK','GET');
		if($task=='BLANK')
			$task = JRequest::getVar('task','BLANK');
			
		$view = JRequest::getVar('view','BLANK');
		
		
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
