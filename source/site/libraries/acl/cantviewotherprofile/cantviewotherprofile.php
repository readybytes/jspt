<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class cantviewotherprofile extends XiptAclBase
{
	function checkAclViolation($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
				
		// if allwoed to self
		if($resourceAccesser == $resourceOwner)
			return false;
		
		return parent::checkAclViolation($data);
	}
	
	function checkAclViolationByPlan($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
				
		// if allwoed to self
		if($resourceAccesser == $resourceOwner)
			return false;
		
		return parent::checkAclViolationByPlan($data);
	}
	
	function getResourceOwner($data)
	{
		return $data['viewuserid'];
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('profile' != $data['view'])
			return false;

		if($data['viewuserid'] != 0 && $data['task'] === '')
				return true;

		return false;
	}

}
