<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessgroup extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		$otherptype = $this->aclparams->get('other_profiletype',-1);

		$groupId	= isset($data['groupid'])? $data['groupid'] : 0;
		$groupId	= JRequest::getVar('groupid' , $groupId, 'REQUEST');

		$groupData  = CFactory::getModel('groups')->getGroup($groupId);
		$ownerid	= $groupData->ownerid;
		$otherpid	= XiptLibProfiletypes::getUserData($ownerid,'PROFILETYPE');

		if(!in_array($otherptype, array(XIPT_PROFILETYPE_ALL,XIPT_PROFILETYPE_NONE,$otherpid)))
			return false;

		if($this->aclparams->get('acl_applicable_to_friend',1) == 0)
		{
			$isFriend = XiptAclHelper::isFriend($data['userid'],$ownerid);
			if($isFriend)
			 return false;
		}

		return true;
	}


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('groups' != $data['view'])
			return false;

		if($data['task'] === 'viewgroup')
				return true;

		return false;
	}

}
