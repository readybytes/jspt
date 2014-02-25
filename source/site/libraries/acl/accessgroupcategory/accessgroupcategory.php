<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessgroupcategory extends XiptAclBase
{
	function getResourceOwner($data)
	{
		$groupId	= isset($data['groupid'])? $data['groupid'] : 0;
		$groupId	= JRequest::getVar('groupid' , $groupId, 'REQUEST');
		
		$db 		= JFactory::getDBO();
		$query		= 'SELECT '.$db->quoteName('ownerid')
						.' FROM '.$db->quoteName('#__community_groups')
						.' WHERE '.$db->quoteName('id').' = '.$db->Quote($groupId);

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
		
		if($this->isApplicableForGroupCategory($data)=== true)
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
		
		if($this->isApplicableForGroupCategory($data)=== true)
			return false;
				
		return true;
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('groups' != $data['view'])
			return false;

		if($data['task'] === 'viewgroup' || $data['task'] == 'display' || $data['task'] == 'viewdiscussion')
				return true;

		return false;
	}
	
	function isApplicableForGroupCategory($data)
	{
		$allowedCats = $this->aclparams->getValue('group_category');
		
		//$allowedCats ==0 means user can access all categories
		if($allowedCats == 0)
			return true;
			
		//check if its applicable on more than 1 category
		$allowedCats = is_array($allowedCats) ? $allowedCats : array($allowedCats);
		
		//in case, he is accessing categories in groups >> all groups instead of directly accessing group
		if($data['task'] == 'display'){
			$catId	= JRequest::getVar('categoryid' , 0);
			
			//accessing all group
			if(!$catId)
				return true;
				
			if(in_array($catId, $allowedCats))
				return true;
			
			return false;
		}
		
		$groupId	= isset($data['groupid'])? $data['groupid'] : 0;
		$groupId	= JRequest::getVar('groupid' , $groupId, 'REQUEST');
		$db 		= JFactory::getDBO();
		$query		= 'SELECT '.$db->quoteName('categoryid')
						.' FROM '.$db->quoteName('#__community_groups')
						.' WHERE '.$db->quoteName('id').' = '.$db->Quote($groupId);

		$db->setQuery( $query );
		$catId = $db->loadResult();
		
		if(!$catId)
			return false;
		
		if (in_array($catId, $allowedCats))
			return true;
			
		return false;
	}

}
