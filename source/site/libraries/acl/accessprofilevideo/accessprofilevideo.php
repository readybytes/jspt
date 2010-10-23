<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessprofilevideo extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		$videoid	= $data['args'][0];
		$ownerid	= $this->getownerId($videoid);
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

		if('profile' != $data['view'])
			return false;

		if($data['task'] === 'ajaxplayprofilevideo')
				return true;

		return false;
	}

	function getownerId($id)
    {
    	$query = new XiptQuery();
    	
    	return $query->select('creator')
    				 ->from('#__community_videos')
    				 ->where(" `id` = $id ")
    				 ->dbLoadQuery("","")
    				 ->loadResult();
    }


	function aclAjaxBlock($msg)
	{
		$objResponse   	= new JAXResponse();
		$title		= JText::_('CC PROFILE VIDEO');
		$objResponse->addScriptCall('cWindowShow', '', $title, 430, 80);
		return parent::aclAjaxBlock($msg, $objResponse);
	}

}