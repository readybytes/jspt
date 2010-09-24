<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class joingroup extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{
		/* otherprofiletype -1 means none
		 * menas users can join any profiletype user group
		 * else if otherprofiletype is 2 means 
		 * particular profiletype user can 't join 
		 * ptype 2 users group more than 2
		 
		$otherptype = $this->getCoreParams('other_profiletype',-1);*/

		$count = $this->getFeatureCounts($data['userid']);
		$maxmimunCount = $this->aclparams->get('joingroup_limit',0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	
	function getFeatureCounts($userid)
	{
		$groupsModel	=& CFactory::getModel('groups');
		return $groupsModel->getGroupsCount($userid);
	}
	
	
	function checkAclAccesibility($data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('groups' != $data['view'])
			return false;
			
		if($data['task']=='ajaxshowjoingroup' || $data['task']=='ajaxsavejoingroup')
				return true;
				
		return false;
	}
	
}
