<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// include files, as we are here from plugin
// so files might not be included for non-component eventss
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

//@TODO: Write language file
//@TODO : Write debug mode messages
//@TODO : check ptypeid in session in registerProfile fn also
class XiPTLibraryPluginHandler
{
	var $mySess ;
	var $params;
	var $mainframe;

	
	function __construct()
	{
		global $mainframe;
		$this->mainframe =& $mainframe;
		 
		$this->mySess = & JFactory::getSession();
		$this->params = JComponentHelper::getParams('com_xipt');
	}
	
	//if value exist in session then return ptype else return false 
	function isPTypeExistInSession() 
	{
		if($this->mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
			&& (($selectedProfiletypeID = $this->mySess->get('SELECTED_PROFILETYPE_ID',0, 'XIPT'))
				 != 0))
				 	return $selectedProfiletypeID;
		else
			return 0;
	}
	
	
	function setDataInSession($what,$value) 
	{
		$this->mySess->set($what,$value, 'XIPT');
	}
	
	function getPType() 
	{
		$selectedProfiletypeID = $this->isPTypeExistInSession();
		if($selectedProfiletypeID)
			return $selectedProfiletypeID;
		else {
			//this fn call during registration so ptype should exist
			//get default value from params
			$defaultProfiletypeID = $this->params->get('defaultProfiletypeID','0');
			assert($defaultProfiletypeID);			
			return $defaultProfiletypeID;
		}
	}
	

	//BLANK means task should be empty
	function event_com_community_register_blank() 
	{
		$show_ptype_during_reg = $this->params->get('show_ptype_during_reg','0');
		
		$selectedProfiletypeID = $this->isPTypeExistInSession();
		
		if($selectedProfiletypeID && $show_ptype_during_reg) {
			$url = JRoute::_('index.php?option=com_xipt&view=registration&ptypeid='.$selectedProfiletypeID,false);
			$link = '<a href='.$url.'>'. JTEXT::_("CLICK HERE").'</a>';
			
			//get profiletype name from ptype id
			$selectedpTypeName = XiPTLibraryProfiletypes::getProfileTypeNameFromID($selectedProfiletypeID);
			$this->mainframe->enqueueMessage(sprintf(JTEXT::_('CURRENT PTYPE AND CHANGE PTYPE OPTION'),$selectedpTypeName,$link));
			return;	
		}
		else if($show_ptype_during_reg)
			$this->mainframe->redirect(JROUTE::_("index.php?option=com_xipt&view=registration",false));
		else if(!$selectedProfiletypeID) {	
			$pType = $this->getPType();
			$this->setDataInSession('SELECTED_PROFILETYPE_ID',$pType);
		}
			
	}
	
	
	function event_com_community_register_registeravatar()
	{
			$profiletypeID = $this->getPType();
			assert($profiletypeID) || JError::raiseError('REGPTYERR',JText::_('PLEASE ASK ADMIN TO SET DEFAULT PROFILETYPE THROUGH ADMIN PANEL OTHERWISE THING WILL NOT WORK PROPERLY')) ;
			
			$user   = $this->mySess->get('tmpUser','','JOMSOCIAL');
			assert($user->id) || JError::raiseError('NOUSERSES',JText_('SESSION EXPIRED NO USER EXIST'));
			if(!XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($user->id)) 
				XiPTLibraryCore::setProfileDataForUserID($user->id,$profiletypeID,'ALL');
			
			$this->setDataInSession('USER_TABLE_ENTRY_DONE',true);
	}
	
	
	//clear session data when user registered successfully
	function event_com_community_register_registersucess() 
	{
		$entryDone = $this->mySess->get('USER_TABLE_ENTRY_DONE','0', 'XIPT');
		if(!$entryDone) {
			$profiletypeID = $this->getPType();
			assert($profiletypeID) || JError::raiseError('REGPTYERR',JText::_('PLEASE ASK ADMIN TO SET DEFAULT PROFILETYPE THROUGH ADMIN PANEL OTHERWISE THING WILL NOT WORK PROPERLY')) ;
			$user   = $this->mySess->get('tmpUser','','JOMSOCIAL');
			assert($user->id);
			if(!XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($user->id)) 
				XiPTLibraryCore::setProfileDataForUserID($user->id,$profiletypeID,'ALL');
		}
			
		 $this->mySess->clear('SELECTED_PROFILETYPE_ID','XIPT');
		 $this->mySess->clear('USER_TABLE_ENTRY_DONE','XIPT');
	}
}
