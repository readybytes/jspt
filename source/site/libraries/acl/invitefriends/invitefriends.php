<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class invitefriends extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('system' != $data['view'])
			return false;

		if($data['task'] == 'ajaxshowinvitationform' || $data['task'] == 'ajaxSubmitInvitation')
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
		
		//$notAllowedCats == 0 means user can't access any category
		if($notAllowedCats == 0)
			return false;
			
		//check if its applicable on more than 1 category
		$notAllowedCats = is_array($notAllowedCats) ? $notAllowedCats : array($notAllowedCats);
		
		$groupId	= $data['args'][2];
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