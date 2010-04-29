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
		
	function plgSystemxipt_system( $subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	
	function onAfterRoute()
	{
 		global $mainframe;

		//sometimes in SEF, value from GET might be blank		
		$option = JRequest::getCmd('option','BLANK','GET');
		if($option == 'BLANK')
			$option = JRequest::getVar('option','');

		//sometimes in SEF, value from GET might be blank
		$task = JRequest::getCmd('task','BLANK','GET');
		if($task=='BLANK')
			$task = JRequest::getVar('task','BLANK');
			
		$view = JRequest::getVar('view','BLANK');
		$component=JRequest::getVar('component','BLANK');
				
		$this->mySess = & JFactory::getSession();
			
		if( $mainframe->isAdmin())
		{	
			if($option == 'com_config' && $component=='com_xipt' && $task=='save')
			{
				$this->mySess->set('saveXiptConfiguration',true);
				return;
			}
			
			if($this->mySess->has('saveXiptConfiguration') == false)
				return;
		}
		

		if(JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php'))
			require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');
		else
			return;
		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
		
		if($this->mySess->get('saveXiptConfiguration',false) == true)
		{	
			$pluginHandler->onAfterConfigSave();
			$this->mySess->set('saveXiptConfiguration',false);
		}		
		
		/*
		switch(trim($option))
		{		 
		    case 'com_community':
		    case 'com_xipt':
		        break;
		        
		    default:
		           return;
		}*/
		

		/*if($option == 'com_community')
		{
			$nothing    = false;
			$pluginHandler->performACLCheck($nothing,$nothing,$nothing);
		}*/
		$nothing    = false;
		$pluginHandler->performACLCheck($nothing,$nothing,$nothing);

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
		
	
	function onAfterStoreUser($properties,$isNew,$result,$error)
	{
		if(JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php'))
			require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
		return $pluginHandler->onAfterStoreUser(array($properties,$isNew,$result,$error));
	}
	
	function onAfterDeleteUser($properties,$result,$error)
	{
		if(JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php'))
			require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
		return $pluginHandler->onAfterDeleteUser(array($properties,$result,$error));
	}
}
