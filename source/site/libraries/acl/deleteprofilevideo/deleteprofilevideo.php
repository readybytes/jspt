<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class deleteprofilevideo extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option']){
			return false;
		}
		
		if(!in_array($data['view'], array('profile' , 'videos'))){
			return false;
		}
			
		if(!in_array($data['task'], array('ajaxremovelinkprofilevideo' , 'ajaxremovevideo'))){
			return false;
		}
		
		if($data['task'] == 'ajaxremovelinkprofilevideo'){
			$videoId = $data['args'][1];
		}else{
			$videoId = $data['args'][0];
		}
		$ownerid = $data['userid'];
		if($this->_isProfileVideo($videoId , $ownerid)){
			return true;
		}

		return false;
	}

	/**
	 * function to check whether video is the profileVideo
	 */
	protected function _isProfileVideo($videoId , $ownerid)
	{
		$query		= new XiptQuery();
	
		$params		= $query->select('params')
							->from('#__community_users')
							->where("userid = $ownerid")
							->dbLoadQuery("","")
							->loadResult();

		$userParams		= json_decode($params, true);
		$profileVideoId = isset($userParams['profileVideo'])?$userParams['profileVideo']:0;
		if($profileVideoId == $videoId){
			return true;
		}
		return false;
	}
}

