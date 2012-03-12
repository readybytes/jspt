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
		return $data['userid'];
	}
	
	function checkAclViolation(&$data)
	{	
		$resourceAccesser 	= XiptAclBase::getResourceAccesser($data);		
		
		if(XiptAclBase::isApplicableOnSelfProfiletype($resourceAccesser) === false)
			return true; 
		
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

		if($data['task'] === 'viewgroup' || $data['task'] == 'display')
				return true;

		return false;
	}
	
	function isApplicableForGroupCategory($data)
	{
		$allowedCats = $this->aclparams->get('group_category');
		
		//check if its applicable on more than 1 category
		$allowedCats = is_array($allowedCats) ? $allowedCats : array($allowedCats);
		
		//in case, he is accessing categories in groups >> all groups instead of directly accessing group
		if($data['task'] == 'display'){
			$catId	= JRequest::getVar('categoryid' , 0);
			
			//accessing all group
			if(!$catId)
				return true;
				
			//$allowedCats ==0 means user can access all categories
			if(in_array($catId, $allowedCats) || $allowedCats == 0)
				return true;
			
			return false;
		}
		
		$groupId	= isset($data['groupid'])? $data['groupid'] : 0;
		$groupId	= JRequest::getVar('groupid' , $groupId, 'REQUEST');
		$db 		= JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('categoryid')
						.' FROM '.$db->nameQuote('#__community_groups')
						.' WHERE '.$db->nameQuote('id').' = '.$db->Quote($groupId);

		$db->setQuery( $query );
		$catId = $db->loadResult();
		
		if(!$catId)
			return false;
		
		//$allowedCats==0 means user can access all categories
		if (in_array($catId, $allowedCats) || $allowedCats == 0)
			return true;
			
		return false;
	}

}
