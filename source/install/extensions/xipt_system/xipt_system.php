<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');

if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php'))
 	return false;
 			
$includeXipt=require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php');	
 		
if($includeXipt === false)
	return false;
	
class plgSystemxipt_system extends JPlugin
{
	var $_debugMode = 1;
	var $_eventPreText = 'event_';
		
	function plgSystemxipt_system( $subject, $params )
	{
		parent::__construct( $subject, $params );
		$this->_pluginHandler = XiptFactory::getLibraryPluginHandler();
	}
	
	
	function onAfterRoute()
	{
		global $mainframe;
		 $oldTablePath = JTable::addIncludePath();
					
		// use factory to get any object
		$pluginHandler = XiptFactory::getLibraryPluginHandler();
					
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
		
	/**
	 * This function will store user's registration information
	 * in the tables, when User object is created
	 * @param $cuser
	 * @return true
	 */
	function onAfterStoreUser($properties,$isNew,$result,$error)
	{
		if($isNew == false || $result == false || $error == true) {
			$this->_pluginHandler->cleanRegistrationSession();
			return true;
		}

		$profiletypeID = $this->_pluginHandler->getRegistrationPType();
		// need to set everything
		XiptLibProfiletypes::updateUserProfiletypeData($properties['id'], $profiletypeID,'', 'ALL');

		//clean the session
		$this->_pluginHandler->cleanRegistrationSession();
		return true;
	}
	
	function onAfterDeleteUser($properties,$result,$error)
	{		
		if($result == false || $error == true)
			return true;		
		
		return XiptFactory::getInstance('users','model')->delete($properties['id']);		
	}
	
	function onBeforeProfileTypeSelection()
	{
		// use factory to get any object
		$pluginHandler = XiptFactory::getLibraryPluginHandler();
		return $pluginHandler->onBeforeProfileTypeSelection();
	
	}
	
	function onAfterProfileTypeSelection($ptypeid)
	{
		// use factory to get any object
		$pluginHandler = XiptFactory::getLibraryPluginHandler();
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
