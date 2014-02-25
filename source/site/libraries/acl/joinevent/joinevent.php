<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class joinevent extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	
	function checkAclViolation($data)
	{
		$resourceAccesser 	= $this->getResourceAccesser($data);
		
		$maxmimunCount = $this->aclparams->getValue('joinevent_limit',null,0);
		$aclevent      = $this->aclparams->getValue('event_category');
		$eventid	= isset($data['eventid'])? $data['eventid'] : $data['args'][0];
		$eventid	= JRequest::getVar('eventid' , $eventid, 'REQUEST');
		
		if($aclevent)
			$catId	   = $this->getCategoryId($eventid);
		else
			$catId	   = 0;
		
		$count = $this->getFeatureCounts($resourceAccesser,$catId);		
		
		if($aclevent == $catId && $count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	function checkAclViolationByPlan($data)
	{
		return $this->checkAclViolation($data);
	}
	
	function getFeatureCounts($resourceAccesser,$catId,$otherptype=null,$aclSelfPtype=null)
	{	
		$condition = '';
		
		if($catId)
			$condition = "WHERE `catid`= $catId";
    				 
		$db		=JFactory::getDBO();
		
		$query	= ' SELECT COUNT(*) FROM ' 
				. $db->quoteName( '#__community_events_members' )
				. ' WHERE ' . $db->quoteName( 'memberid' ) . '=' . $db->Quote( $resourceAccesser )
				. ' AND ' . $db->quoteName( 'status' ) . '=' . $db->Quote( '1' )
				. ' AND ' . $db->quoteName('eventid') . 'IN'
				. ' (SELECT id FROM '
				. $db->quoteName( '#__community_events' )
				. "$condition)";
				
		$db->setQuery( $query );
		$result	= $db->loadResult();
		return $result;
	}


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('events' != $data['view'])
			return false;

		//if user is clicking on not attend, then don't restrict him
		//option, views & task is same for attend and not attend, so checking args
		if($data['args'][1] == 2)
			return false;
			
		if($data['task']=='updatestatus' || $data['task']=='ajaxupdatestatus')
				return true;

		return false;
	}

	function getCategoryId($eventid)
	{
		$query = new XiptQuery();
    	
		return $query->select('catid')
						->from('#__community_events')
						->where("`id` = $eventid")
						->dbLoadQuery("","")
	    				->loadResult();
	}
}
