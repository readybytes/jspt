<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class creategroup extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];
	}
	
	function checkAclViolation(&$data)
	{
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);
		$aclSelfPtype 		= $this->getACLAccesserProfileType();
		$otherptype 		= $this->getACLOwnerProfileType();
		
		$maxmimunCount = $this->aclparams->get('creategroup_limit',0);
		$count = $this->getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype,$aclSelfPtype);
		
		$catId	= JRequest::getVar('categoryid' , 0);
		$aclgroup = $this->aclparams->get('group_category');

		if ($aclgroup === $catId || $count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	function getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype,$aclSelfPtype)
	{
		$query = new XiptQuery();
    	
    	return $query->select('COUNT(*)')
    				 ->from('#__community_groups')
    				 ->where(" `ownerid` = $resourceAccesser ", 'AND')
    				 ->dbLoadQuery("","")
    				 ->loadResult();
	}


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('groups' != $data['view'])
			return false;

		if($data['task']=='create')
				return true;

		return false;
	}
}
