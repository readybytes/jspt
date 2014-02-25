<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class joingroup extends XiptAclBase
{
	function getResourceOwner($data)
	{
		$groupid   	   = $data['args'][0];
		$groupInfo	   = $this->getGroupInfo($groupid);
		
		return $groupInfo->ownerid;	
	}
	
	function checkAclViolation($data)
	{
		$resourceAccesser 	= $this->getResourceAccesser($data);
		$resourceOwner 		= $this->getResourceOwner($data);
		
		// if resource owner is friend of resource accesser 
		if($this->isApplicableOnFriend($resourceAccesser,$resourceOwner) === false)
			return false; 
		
		$maxmimunCount = $this->aclparams->getValue('joingroup_limit',null,0);
		$aclgroup      = $this->aclparams->getValue('group_category');
		$groupid   	   = $data['args'][0];
		
		if($aclgroup){
			$groupInfo = $this->getGroupInfo($groupid);
			$catId	   = $groupInfo->categoryid;
		}
		else
			$catId	   = 0;
		
		$count = $this->getFeatureCounts($resourceAccesser,$catId);		
		
		if($aclgroup == $catId && $count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	function checkAclViolationByPlan($data)
	{
		return $this->checkAclViolation($data);
	}
	
	function getFeatureCounts($resourceAccesser,$catId,$otherptype=null,$aclSelfPtype=null)
	{
		
		if($catId)
			$condition = "WHERE `categoryid`= $catId";
    	else
			$condition = '';
		$db		=JFactory::getDBO();
		
		$query	= ' SELECT COUNT(*) FROM ' 
				. $db->quoteName( '#__community_groups_members' )
				. ' WHERE ' . $db->quoteName( 'memberid' ) . '=' . $db->Quote( $resourceAccesser )
				. ' AND ' . $db->quoteName( 'approved' ) . '=' . $db->Quote( '1' )
				. ' AND ' . $db->quoteName('groupid') . 'IN'
				. ' (SELECT id FROM '
				. $db->quoteName( '#__community_groups' )
				. "$condition)";
				
		$db->setQuery( $query );
		$result	= $db->loadResult();
		return $result;
	}


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('groups' != $data['view'])
			return false;

		$task = array('ajaxshowjoingroup', 'ajaxsavejoingroup', 'ajaxjoingroup');
		if(in_array($data['task'], $task))
				return true;

		return false;
	}

	function getGroupInfo($groupid)
	{
		$query = new XiptQuery();
    	
		return $query->select("`categoryid`, `ownerid`")
						->from('#__community_groups')
						->where("`id` = $groupid")
						->dbLoadQuery("","")
	    				->loadObject();
	}
}
