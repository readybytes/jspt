<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class creatediscussion extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option']
		    	&& 'groups' == $data['view']
		    	&& $data['task'] == 'adddiscussion')
			return true;

		return false;
	}
	
	function checkAclViolation($data)
	{
		$resourceAccesser 	= $this->getResourceAccesser($data);		
			
		if(XiptAclBase::isApplicableOnSelfProfiletype($resourceAccesser) === false)
			return true;
		
		if($this->isApplicableForGroupCategory($data)=== true)
			return false;
				
		return true;
	}
	
	function checkAclViolationByPlan($data)
	{
		$resourceAccesser 	= $this->getResourceAccesser($data);
		
		if($this->isApplicableOnSelfPlan($resourceAccesser) === false)
			return false;
		
		if($this->isApplicableForGroupCategory($data)=== true)
			return false;
				
		return true;
	}
	
	function isApplicableForGroupCategory($data)
	{
		$notAllowedCats = $this->aclparams->getValue('group_category');
		
		//check if its applicable on more than 1 category
		$notAllowedCats = is_array($notAllowedCats) ? $notAllowedCats : array($notAllowedCats);
		
		//$notAllowedCats == 0 means user can't access any category
		if(in_array(0, $notAllowedCats))
			return false;
		
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
		
		if (!in_array($catId, $notAllowedCats))
			return true;
			
		return false;
	}
}