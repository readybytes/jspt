<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accesseventcategory extends XiptAclBase
{
	function getResourceOwner($data)
	{
		$eventId	= isset($data['eventid'])? $data['eventid'] : 0;
		$eventId	= JRequest::getVar('eventid' , $eventId, 'REQUEST');
		
		$db 		= JFactory::getDBO();
		$query		= 'SELECT '.$db->quoteName('creator')
					.' FROM '.$db->quoteName('#__community_events')
					.' WHERE '.$db->quoteName('id').' = '.$db->Quote($eventId);

		$db->setQuery( $query );
		$data['viewuserid'] = $db->loadResult();

		return $data['viewuserid'];
	}
	
	function checkAclViolation($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
		
		if($this->isApplicableOnSelf($resourceAccesser,$resourceOwner) === false)
			return false;
			
		if(XiptAclBase::isApplicableOnSelfProfiletype($resourceAccesser) === false)
			return true; 
		
		if($this->isApplicableOnFriend($resourceAccesser,$resourceOwner) === false)
			return false;
		
		if($this->isApplicableForEventCategory($data)=== true)
			return false;
				
		return true;
	}
	
	function checkAclViolationByPlan($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
		
		if($this->isApplicableOnSelf($resourceAccesser,$resourceOwner) === false)
			return false;
		
		if($this->isApplicableOnSelfPlan($resourceAccesser) === false)
			return false;
		
		// if resource owner is friend of resource accesser 
		if($this->isApplicableOnFriend($resourceAccesser,$resourceOwner) === false)
			return false; 
		
		if($this->isApplicableForEventCategory($data)=== true)
			return false;
				
		return true;
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('events' != $data['view'])
			return false;

		if($data['task'] === 'viewevent' || $data['task'] == 'display')
				return true;

		return false;
	}
	
	function isApplicableForEventCategory($data)
	{
		$allowedCats = $this->aclparams->getValue('event_category');
		
		//$allowedCats ==0 means user can access all categories
		if($allowedCats == 0)
			return true;
			
		//check if its applicable on more than 1 category
		$allowedCats = is_array($allowedCats) ? $allowedCats : array($allowedCats);
		
		//in case, he is accessing categories in events >> all events instead of directly accessing event
		if($data['task'] == 'display'){
			$catId	= JRequest::getVar('categoryid' , 0);
			
			//accessing all events
			if(!$catId)
				return true;
			
			if(in_array($catId, $allowedCats))
				return true;
			
			return false;
		}
		
		$eventId	= isset($data['eventid'])? $data['eventid'] : 0;
		$eventId	= JRequest::getVar('eventid' , $eventId, 'REQUEST');
		$db 		= JFactory::getDBO();
		$query		= 'SELECT '.$db->quoteName('catid')
						.' FROM '.$db->quoteName('#__community_events')
						.' WHERE '.$db->quoteName('id').' = '.$db->Quote($eventId);

		$db->setQuery( $query );
		$catId = $db->loadResult();
		
		if(!$catId)
			return false;
		
		if (in_array($catId, $allowedCats))
			return true;
			
		return false;
	}

}
