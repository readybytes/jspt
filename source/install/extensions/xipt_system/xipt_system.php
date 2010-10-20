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
	private $_pluginHandler;
		
	function plgSystemxipt_system( $subject, $params )
	{
		parent::__construct( $subject, $params );
		$this->_pluginHandler = XiptFactory::getPluginHandler();
	}
	
	
	function onAfterRoute()
	{
		$app = JFactory::getApplication();
							
		if($app->isAdmin()){	
 			if($this->_pluginHandler->checkSetupRequired())
 				$app->enqueueMessage(JText::_('JSPT SETUP SCREEN IS NOT CLEAN, PLEASE CLEAN IT.'));
 				
 			return false;
 		} 		
			
		// get option, view and task		
		$option 	= JRequest::getVar('option','BLANK');
		$view 		= JRequest::getVar('view','BLANK');		
		$task 		= JRequest::getVar('task','BLANK');
		$component	= JRequest::getVar('component','BLANK');			

		// perform all acl check from here
		XiptAclHelper::performACLCheck(false, false, false);		

		//do routine works
		$eventName = $this->_eventPreText.strtolower($option).'_'.strtolower($view).'_'.strtolower($task);
		//call defined event to handle work
		$exist = method_exists($this,$eventName);
		if($exist)
			$this->$eventName();
			
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
	
	// this is trigerred on registraion page of xipt 
	function onBeforeProfileTypeSelection()
	{
		// if user comes from genaral registration link then return
		$ptypeid = JRequest::getVar('ptypeid',0,'GET');
		
		// if user comes from a direct link (with profile type selected) 
		// the reset will be false or does not exist	
		// if user comes for selecting profile type again then reset is true
		$reset = JRequest::getVar('reset',false,'GET');

		if($ptypeid == 0 || $reset)
			return true;

		XiptHelperProfiletypes::setProfileTypeInSession($ptypeid);
		return true;	
	}
	
	// this is trigerred on after post on registration page of xipt
	function onAfterProfileTypeSelection($ptypeid)
	{
		// set the profile type in session
		XiptHelperProfiletypes::setProfileTypeInSession($ptypeid);	
	}
	
	/* 
	 * Events generated from the onAfterRoute
	 */
	
	//BLANK means task should be empty
	function event_com_community_register_blank()
	{
		return $this->_pluginHandler->integrateRegistrationWithPType();
	}
	
	function event_com_user_register_blank()
	{
	    return $this->_pluginHandler->integrateRegistrationWithPType();
	}
	
	function event_com_community_profile_blank()
	{		
		if(!$this->_pluginHandler->getDataInSession('FROM_FACEBOOK',false))
			return true;
		
		// reset the session data of FROM_FACEBOOK
		$this->_pluginHandler->resetDataInSession('FROM_FACEBOOK');	
	
		if(XiptFactory::getSettings('aec_integrate', 0) == true) {
			$link = XiptRoute::_('index.php?option=com_acctexp&task=subscribe',false);
			JFactory::getApplication()->redirect($link);
		}

		return true;
	}
	
	/* get the plan id when the direct link of AEC are used */
	function event_com_acctexp_blank_subscribe()
	{		
		$usage  = JRequest::getVar( 'usage', 0, 'REQUEST');
		//XiptError::assert($usage);				
		$this->_pluginHandler->setDataInSession('AEC_REG_PLANID', $usage);			
	}
	
	// we are on xipt registration page
	function event_com_xipt_registration_blank()
	{		
	    $aecExists 		= XiptLibAec::isAecExists();
	    $integrateAEC   = XiptFactory::getSettings('aec_integrate');	   

	    // check AEC exist or not 
	    // AND check JSPT is integrated with AEC or not
	    if(!$aecExists || !$integrateAEC)
	        return;

	    // find selected profiletype from AEC
	    $aecData = XiptLibAec::getProfiletypeInfoFromAEC();
		$app	 = JFactory::getApplication();
		
	    // as user want to integrate the AEC so a plan must be selected
        // send user to profiletype selection page
	    if($aecData['planSelected'] == false)
	        $app->redirect(XiptRoute::_('index.php?option=com_acctexp&task=subscribe',false),JText::_('PLEASE SELECT AEC PLAN, IT IS RQUIRED'));

	    // set selected profiletype in session
	    $this->_pluginHandler->mySess->set('SELECTED_PROFILETYPE_ID',$aecData['profiletype'], 'XIPT');
	    $app->redirect(XiptHelperJomsocial::getReturnURL());
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
