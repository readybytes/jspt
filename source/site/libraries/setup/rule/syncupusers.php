<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptSetupRuleSyncupusers extends XiptSetupBase
{
	function isRequired()
	{
		$params = XiptFactory::getSettings('', 0);
		$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
		
		if(!$defaultProfiletypeID){
			global $mainframe;
			$mainframe->enqueueMessage(XiptText::_("FIRST SELECT THE DEFAULT PROFILE TYPE"));
			return false;
		}

		$PTFieldId = XiptHelperJomsocial::getFieldId(PROFILETYPE_CUSTOM_FIELD_CODE);
		$TMFieldId = XiptHelperJomsocial::getFieldId(TEMPLATE_CUSTOM_FIELD_CODE);
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return true;
			
		$result = $this->getUsertoSyncUp();
		
		if(empty($result))
		{
			return false;
		}
		
		return true;
	}
	
	function doApply()
	{
		$start=JRequest::getVar('start', 0);
		$limit=JRequest::getVar('limit',SYNCUP_USER_LIMIT);
		if($this->syncUpUserPT($start,$limit))
        	return XiptText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZED SUCCESSFULLY');
        
        return XiptText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZATION FAILED');
	}
	
	function syncUpUserPT($start, $limit, $test = false)
	{
		
		$PTFieldId = XiptHelperJomsocial::getFieldId(PROFILETYPE_CUSTOM_FIELD_CODE);
		$TMFieldId = XiptHelperJomsocial::getFieldId(TEMPLATE_CUSTOM_FIELD_CODE);
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return false;
			
		$result = $this->getUsertoSyncUp($start, $limit);
		$profiletype = XiPTLibProfiletypes::getDefaultProfiletype();
		$template	 = XiPTLibProfiletypes::getProfileTypeData($profiletype,'template');			
		
		foreach ($result as $userid)
			XiPTLibProfiletypes::updateUserProfiletypeData($userid, $profiletype, $template, 'ALL');
			
		if($test)
			return true;
		
		$mainframe = JFactory::getApplication();
		if(sizeof($result)== $limit){			
			$start+=$limit;
    		$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=syncUpUserPT&start=$start",false));
		}
		
		$msg = 'Total '. ($start+count($result)) . ' users '.XiptText::_('synchornized');
		$mainframe->enqueueMessage($msg);
		return true;
	}
	
	function getMessage()
	{
		$requiredSetup = array();
		
		if($this->isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=syncupusers",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.XiptText::_("PLEASE CLICK HERE TO SYNC UP USERS PROFILETYPES").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = XiptText::_("USERS PROFILETYPES ALREADY IN SYNC");
			$requiredSetup['done']  = true;
		}
		return $requiredSetup;
	}
	
	function getUsertoSyncUp($start = 0, $limit = 1000)
	{
		//XITODO : apply caching
//		static $users = null;
//		$reset = XiptLibJomsocial::cleanStaticCache();
//		if($users!== null && $reset == false)
//			return $users;

		$db 	= JFactory::getDBO();	
		// XITODO : PUT into query Object
		$xiptquery = ' SELECT `userid` FROM `#__xipt_users` ';
		$query 	= ' SELECT `userid` FROM `#__community_users` '
					.' WHERE `userid` NOT IN ('.$xiptquery.') ';
        			
		$db->setQuery($query);
		$result = $db->loadResultArray();

		$query = ' SELECT `userid` FROM `#__xipt_users` WHERE `profiletype` NOT IN ( SELECT `id` FROM `#__xipt_profiletypes` )';
		$db->setQuery($query);
		$userid = $db->loadResultArray();
		
		$users = array_merge($result, $userid);
		
		sort($users);
		
		return array_slice($users, $start, $limit);
	}
	
}