<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessvideo extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		$otherptype = $this->aclparams->get('other_profiletype',-1);

		$videoId = isset($data['videoid']) ? $data['videoid'] : '';
		$videoId	= JRequest::getVar( 'videoid' , $videoId );
		$video	    = CFactory::getModel('videos');
		$videoData  = $video->getVideos(array('id'=>$videoId));
		$creatorid	= $videoData[0]->creator;

		$otherpid	= XiptLibProfiletypes::getUserData($creatorid,'PROFILETYPE');


		if(!in_array($otherptype, array(XIPT_PROFILETYPE_ALL,XIPT_PROFILETYPE_NONE,$otherpid)))
			return false;

		if($this->aclparams->get('acl_applicable_to_friend',1) == 0)
		{
			//this was a bug
			$isFriend = XiptAclHelper::isFriend($data['userid'],$creatorid);
			if($isFriend)
			 return false;
		}

		return true;
	}


	function checkAclApplicable(&$data)
	{
		/*XITODO : we will expect that vie task and should be given
		 * and from parsing we will find out that is this request for me
		 */
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('videos' != $data['view'])
			return false;

		if($data['task'] === 'video')
				return true;

		return false;
	}

}