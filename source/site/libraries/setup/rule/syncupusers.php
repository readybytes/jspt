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
		$params = XiptFactory::getSettingParams('', 0);
		$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
		
		if(!$defaultProfiletypeID){
			global $mainframe;
			$mainframe->enqueueMessage(JText::_("FIRST SELECT THE DEFAULT PROFILE TYPE"));
			return false;
		}

		$PTFieldId = $this->getFieldId(PROFILETYPE_CUSTOM_FIELD_CODE);
		$TMFieldId = $this->getFieldId(TEMPLATE_CUSTOM_FIELD_CODE);
		
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
		$start=JRequest::getVar('start', 0, 'GET');
		$limit=JRequest::getVar('limit',SYNCUP_USER_LIMIT, 'GET');
		if(self::syncUpUserPT($start,$limit))
        	return JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZED SUCCESSFULLY');
        
        return JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZATION FAILED');
	}
	
	function syncUpUserPT($start, $limit, $test = false)
	{
		
		$PTFieldId = $this->getFieldId(PROFILETYPE_CUSTOM_FIELD_CODE);
		$TMFieldId = $this->getFieldId(TEMPLATE_CUSTOM_FIELD_CODE);
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return false;
			
		$result = $this->getUsertoSyncUp($start, $limit);

		foreach ($result as $userid)
		{
			$profiletype = XiPTLibProfiletypes::getDefaultProfiletype();
			$template	 = XiPTLibProfiletypes::getProfileTypeData($profiletype,'template');;
			XiPTLibProfiletypes::updateUserProfiletypeData($userid, $profiletype, $template, 'ALL');
		}
		
		if($test)
		{
			return true;
		}
		
		global $mainframe;
		if(sizeof($result)== $limit){			
			$start+=$limit;
    		$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=syncUpUserPT&start=$start",false));
		}
		
		$msg = 'Total '. ($start+count($result)) . ' users '.JText::_('synchornized');
		$mainframe->enqueueMessage($msg);
		return true;
	}
	
	function getMessage()
	{
		$requiredSetup = array();
		
		if($this->isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=syncupusers",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO SYNC UP USERS PROFILETYPES").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = JText::_("USERS PROFILETYPES ALREADY IN SYNC");
			$requiredSetup['done']  = true;
		}
		return $requiredSetup;
	}
	
	function getUsertoSyncUp($start = 0, $limit = 1000)
	{
		static $users = null;
		$reset = XiptLibJomsocial::cleanStaticCache();
		if($users!== null && $reset == false)
			return $users;

		$db 	= JFactory::getDBO();	
		$query 	= ' SELECT `userid` FROM `#__community_users` ';
        			
		$db->setQuery($query);
		$commResult = $db->loadResultArray();
		
		$xiptquery = ' SELECT `userid` FROM `#__xipt_users` ';

		$db->setQuery($xiptquery);
		$xiptResult = $db->loadResultArray();
		
		$result = array_diff($commResult, $xiptResult);
		
		$query = ' SELECT `userid` FROM `#__xipt_users` WHERE `profiletype` NOT IN ( SELECT `id` FROM `#__xipt_profiletypes` )';
		$db->setQuery($query);
		$userid = $db->loadResultArray();
		
		$users = array_merge($result, $userid);
		
		sort($users);
		
		return array_slice($users, $start, $limit);
	}
	
	function getFieldId($fieldcode)
	{
		static $results = array();
		
		$reset = XiptLibJomsocial::cleanStaticCache();
		if(isset($results[$fieldcode]) && $reset == false)
			return $results[$fieldcode]['id'];
		
		$db			= JFactory::getDBO();
		$query		= 'SELECT * FROM '
					. $db->nameQuote( '#__community_fields' );
		
		$db->setQuery( $query );
		$results  = $db->loadAssocList('fieldcode');
		if(array_key_exists($fieldcode, $results))
			return $results[$fieldcode]['id'];
		
	}
}