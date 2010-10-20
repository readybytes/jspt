<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class cantviewotherprofile extends XiptAclBase
{

	public function checkAclViolation($data)
	{
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		$otherpid	= XiptLibProfiletypes::getUserData($data['viewuserid'],'PROFILETYPE');

		// do not restrict self
		if($data['userid'] == $data['viewuserid'])
			return false;

		if(!in_array($otherptype, array(XIPT_PROFILETYPE_ALL,XIPT_PROFILETYPE_NONE,$otherpid)))
			return false;

		if($this->aclparams->get('acl_applicable_to_friend',1) == 0)
		{
			$isFriend = XiptAclHelper::isFriend($data['userid'],$data['viewuserid']);
			if($isFriend)
			 return false;
		}

		return true;
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
