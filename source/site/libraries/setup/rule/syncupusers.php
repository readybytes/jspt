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
		$params = XiptFactory::getParams('', 0);
		$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
		if(!$defaultProfiletypeID){
			global $mainframe;
			$mainframe->enqueueMessage(JText::_("FIRST SELECT THE DEFAULT PROFILE TYPE"));
			return false;
		}

		//for every user
		$db 	= JFactory::getDBO();
		$query	= ' SELECT `id` FROM `#__community_fields` '
				. ' WHERE `fieldcode`=\''.PROFILETYPE_CUSTOM_FIELD_CODE.'\' ';
		$db->setQuery($query);
		$PTFieldId=$db->loadResult();
		
		$query	= ' SELECT `id` FROM `#__community_fields` '
				. ' WHERE `fieldcode`=\''.TEMPLATE_CUSTOM_FIELD_CODE.'\' ';
		$db->setQuery($query);
		$TMFieldId=$db->loadResult();
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return true;
			
		$query 	= ' SELECT u.`userid` as id, vPT.`value` AS vptype, vTM.`value` AS vtemp, xUser.* '
				.' FROM `#__community_users` AS u '
				.' LEFT JOIN `#__community_fields_values` AS vPT'
        		.' ON ( vPT.`user_id` = u.`userid` AND  vPT.`field_id`='.$db->Quote($PTFieldId).')'
				.' LEFT JOIN `#__community_fields_values` AS vTM'
        		.' ON ( vTM.`user_id` = u.`userid` AND  vTM.`field_id`='.$db->Quote($TMFieldId).')'
				.' LEFT JOIN `#__xipt_users` AS '.'xUser'
        		.' ON ( xUser.`userid` = u.`userid` )';
        			
		$db->setQuery($query);
		$result = $db->loadObjectList();

		if(empty($result))
		{
			return false;
		}
		
		foreach ($result as $r){
			if(!($r->vptype && $r->profiletype && $r->vtemp && $r->template) 
					|| XiptLibProfiletypes::validateProfiletype($r->profiletype)==false)
				return true;
				
			if($r->vptype != $r->profiletype)
				return true;
			if($r->vtemp != $r->template)
				return true;
		}
		
		return false;
	}
	
	function doApply()
	{
		$start=JRequest::getVar('start', 0, 'GET');
		$limit=JRequest::getVar('limit',SYNCUP_USER_LIMIT, 'GET');
		if(self::syncUpUserPT($start,$limit))
        	return JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZED SUCCESSFULLY');
        
        return JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZATION FAILED');
	}
	
	function syncUpUserPT($start, $limit)
	{
		
		//	for every user
		$db 	= JFactory::getDBO();
		$query	= ' SELECT `id` FROM `#__community_fields` '
				. ' WHERE `fieldcode`=\''.PROFILETYPE_CUSTOM_FIELD_CODE.'\' ';
		$db->setQuery($query);
		$PTFieldId=$db->loadResult();
		
		$query	= ' SELECT `id` FROM `#__community_fields` '
				. ' WHERE `fieldcode`=\''.TEMPLATE_CUSTOM_FIELD_CODE.'\' ';
		$db->setQuery($query);
		$TMFieldId=$db->loadResult();
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return false;
			
		$query 	= ' SELECT u.`userid` as id, vPT.`value` AS vptype, vTM.`value` AS vtemp, xUser.* '
				.' FROM `#__community_users` AS u '
				.' LEFT JOIN `#__community_fields_values` AS vPT'
        		.' ON ( vPT.`user_id` = u.`userid` AND  vPT.`field_id`='.$db->Quote($PTFieldId).')'
				.' LEFT JOIN `#__community_fields_values` AS vTM'
        		.' ON ( vTM.`user_id` = u.`userid` AND  vTM.`field_id`='.$db->Quote($TMFieldId).')'
				.' LEFT JOIN `#__xipt_users` AS '.'xUser'
        		.' ON ( xUser.`userid` = u.`userid` ) '
        		.' LIMIT '.$start.','.$limit;
        			
		$db->setQuery($query);
		$result = $db->loadObjectList();
					
		 $i=0;
		foreach ($result as $r){
			
			//skip correct users
			if($r->vptype && $r->profiletype && $r->vtemp && $r->template && XiptLibProfiletypes::validateProfiletype($r->profiletype)==true)
			{
				if(($r->vptype == $r->profiletype) && ($r->vtemp == $r->template))
					continue;
			}
			
			//It ensure that system will pickup correct data
			$profiletype = XiptLibProfiletypes::getUserData($r->id,'PROFILETYPE');
			if(XiptLibProfiletypes::validateProfiletype($profiletype)==true)
			{
				$template	 = XiptLibProfiletypes::getUserData($r->id,'TEMPLATE');
			}
			else
			{
				$profiletype = XiptLibProfiletypes::getDefaultProfiletype();
				$template	 = XiptLibProfiletypes::getProfileTypeData($profiletype,'template');;
			}
			XiptLibProfiletypes::updateUserProfiletypeData($r->id, $profiletype, $template, 'ALL');
			$i++;
		}
		global $mainframe;
		if(sizeof($result)== $limit){			
			$start+=$limit;
    		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=syncUpUserPT&start=$start",false));
		}
		
		$msg = 'Total '. ($start+$i) . ' users '.JText::_('synchornized');
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
}