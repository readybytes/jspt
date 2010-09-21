<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

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
	
	function _includeXipt()
	{
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php'))
 			return false;
 			
		$includeXipt=require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');	
 		
		if( isset($includeXipt) && $includeXipt === false)
			return false;
			
		return true;
	}
	
	function onAfterRoute()
	{
		global $mainframe;
		 $oldTablePath = JTable::addIncludePath();
		
		if(!$this->_includeXipt())
			return false;
				
		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
					
 		if( $mainframe->isAdmin())
 		{	
 			if($pluginHandler->checkSetupRequired())
 				$mainframe->enqueueMessage(JText::_('JSPT SETUP SCREEN IS NOT CLEAN, PLEASE CLEAN IT.'));
 		     	
			JTable::addIncludePath($oldTablePath);
 			return false;
 		} 		
			
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
				

		$nothing    = false;
		$pluginHandler->performACLCheck($nothing,$nothing,$nothing);

		//do routine works
		$eventName = $this->_eventPreText.strtolower($option).'_'.strtolower($view).'_'.strtolower($task);
		
		//call defined event to handle work
		$exist = method_exists($pluginHandler,$eventName);
		if($exist)
		{
			//call function
			$pluginHandler->$eventName();
		}
		JTable::addIncludePath($oldTablePath);	
		return false;
	}
		
	
	function onAfterStoreUser($properties,$isNew,$result,$error)
	{
		if(!$this->_includeXipt())
			return false;
		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
		return $pluginHandler->onAfterStoreUser(array($properties,$isNew,$result,$error));
	}
	
	function onAfterDeleteUser($properties,$result,$error)
	{
		if(!$this->_includeXipt())
			return false;
		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
		return $pluginHandler->onAfterDeleteUser(array($properties,$result,$error));
	}
	
	function onBeforeProfileTypeSelection()
	{
		if(!$this->_includeXipt())
			return false;
			
		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
		return $pluginHandler->onBeforeProfileTypeSelection();
	
	}
	
	function onAfterProfileTypeSelection($ptypeid)
	{
		if(!$this->_includeXipt())
			return false;
			
		// use factory to get any object
		$pluginHandler = XiPTFactory::getLibraryPluginHandler();
		return $pluginHandler->onAfterProfileTypeSelection($ptypeid);	
	}
	
	
	// $userInfo ia an array and contains contains
	// userid
	// oldPtype
	// & newPtype
	function onBeforeProfileTypeChange($userInfo)
	{	    
		return false;
	}
	
	function onAfterProfileTypeChange($newPtype, $result)
	{
		return false;
	}
}
