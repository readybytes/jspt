<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addvideos extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		$count = $this->getFeatureCounts($data['userid']);
		$maxmimunCount = $this->aclparams->get('addvideos_limit',0);
		if($count >= $maxmimunCount)
			return true;

		return false;
	}

	function getFeatureCounts($userid)
	{
		$query = new XiptQuery();
    	
    	return $query->select('COUNT(*)')
    				 ->from('#__community_videos')
    				 ->where(" `creator` = $userid ", 'AND')
    				 ->where(" `published` = '1' ", 'AND')
    				 ->where(" `status` = 'ready' ")
    				 ->dbLoadQuery("","")
    				 ->loadResult();
	}


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('videos' != $data['view'])
			return false;

		if($data['task'] == 'ajaxaddvideo' || $data['task'] == 'ajaxuploadvideo')
				return true;

		return false;
	}

}
