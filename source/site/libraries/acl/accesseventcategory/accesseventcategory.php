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

		if($data['task'] === 'viewevent')
				return true;

		return false;
	}
	
	function isApplicableForEventCategory($data)
	{
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
			
		$allowedCats = $this->aclparams->get('event_category');
		
		//check if its applicable on more than 1 category
		$allowedCats = is_array($allowedCats) ? $allowedCats : array($allowedCats);
		
		//$allowedCats == 0 means user can access all categories
		if (in_array($catId, $allowedCats) || $allowedCats == 0)
			return true;
			
		return false;
	}

}
