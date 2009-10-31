<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license Copyrighted Commercial Software
 */

// no direct access

defined('_JEXEC') or die('Restricted access');

define('XIPT_NOT_DEFINED','XIPT_NOT_DEFINED');


require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'profiletypes.php');
//@TODO: Write language file
//@TODO : Write debug mode messages
//@TODO : Remove ptypeid from session when registersuccess
//@TODO : check ptypeid in session in registerProfile fn also
class XiPTLibraryPluginHandler
{
	var $mySess ;

	
	function __construct()
	{
		$this->mySess = & JFactory::getSession();
	}
	
	//@TODO : Break fn checkPTypeinSession into 
	//1. check isValueExistinSession
	//2. setValueinSession
	function checkPTypeinSession() {
		global $mainframe;
		//1. check ptype value in session
		// if exist then enqueuemessage to chane ptype
		
		if($this->mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
			&& (($selectedProfiletypeID = $this->mySess->get('SELECTED_PROFILETYPE_ID','XIPT_NOT_DEFINED', 'XIPT'))
				 != 'XIPT_NOT_DEFINED'))
		{
			$url = JRoute::_('index.php?option=com_xipt&view=registration&ptypeid='.$selectedProfiletypeID,false);
			$link = '<a href='.$url.'>'. JTEXT::_("CLICK HERE").'</a>';
			
			//get profiletype name from ptype id
			$selectedpTypeName = XiPTLibraryProfiletypes::getProfileTypeNameFromID($selectedProfiletypeID);
			$mainframe->enqueueMessage(sprintf(JTEXT::_("YOUR CURRENT PROFILETYPE IS %s , TO CHANGE PROFILETYPE CLICK HERE %s"),$selectedpTypeName,$link));
			return;	
		}
		
		//2. if not exist redirect to ptype selection display page.
		// check ptype selection is visible during registration or not
		//if not then set default ptype in session
		
		
		$params = JComponentHelper::getParams('com_xipt');
		$show_ptype_during_reg = $params->get('show_ptype_during_reg','0');

		if($show_ptype_during_reg)
			$mainframe->redirect(JROUTE::_("index.php?option=com_xipt&view=registration",false));
		else
		{
			//get default value from params
			//@TODO : change defaultpype name and jspt_during_rec in config.xml
			$defaultProfiletypeID = $params->get('defaultProfiletypeID','XIPT_NOT_DEFINED');
			$this->mySess->set('SELECTED_PROFILETYPE_ID',$defaultProfiletypeID, 'XIPT');
		}
	}
	
	//@TODO : make deceision here only
	//BLANK means task should be empty
	function event_com_community_register_blank() {
		$this->checkPTypeinSession();
	}
	
	//clear session data when user registered successfully
	function event_com_community_register_registersucess() {
		 $this->mySess->clear('SELECTED_PROFILETYPE_ID','XIPT');
	}
}