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
	}
	
	
	/**
	 * Example store user method
	 *
	 * Method is called after user data is stored in the database
	 *
	 * @param 	array		holds the new user data
	 * @param 	boolean		true if a new user is stored
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onAfterStoreUser($user, $isnew, $success, $msg)
	{
		global $mainframe;

		// convert the user parameters passed to the event
		// to a format the external application

		$args = array();
		$args['username']	= $user['username'];
		$args['email'] 		= $user['email'];
		$args['fullname']	= $user['name'];
		$args['password']	= $user['password'];
		/*
		if ($isnew)
		{
			$mySess = & JFactory::getSession();
			$profiletypeID = $mySess->get('SELECTED_PROFILETYPE_ID','0', 'XIPT');
			$params = JComponentHelper::getParams('com_xipt');
			if(!$profiletypeID)
				$profiletypeID = $params->get('defaultProfiletypeID','0');
			assert($profiletypeID);
			XiPTLibraryProfiletypes::setProfileDataForUserID($user['id'],$profiletypeID,'ALL');
			// Call a function in the external app to create the user
			// ThirdPartyApp::createUser($user['id'], $args);
		}
		else
		{
	
		}
		
		*/
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
		
		require_once( JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'pluginhandler.php' );
		
		$pluginHandler = new XiPTLibraryPluginHandler();
		
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