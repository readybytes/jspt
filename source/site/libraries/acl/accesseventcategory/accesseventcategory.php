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
		return $data['userid'];
	}
	
	function checkAclViolation(&$data)
	{	
		$resourceAccesser 	= XiptAclBase::getResourceAccesser($data);		
		
		if(XiptAclBase::isApplicableOnSelfProfiletype($resourceAccesser) === false)
			return true; 
		
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
		$allowedCats = $this->aclparams->get('event_category');
		
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
		$query		= 'SELECT '.$db->nameQuote('catid')
						.' FROM '.$db->nameQuote('#__community_events')
						.' WHERE '.$db->nameQuote('id').' = '.$db->Quote($eventId);

		$db->setQuery( $query );
		$catId = $db->loadResult();
		
		if(!$catId)
			return false;
		
		if (in_array($catId, $allowedCats))
			return true;
			
		return false;
	}

}
