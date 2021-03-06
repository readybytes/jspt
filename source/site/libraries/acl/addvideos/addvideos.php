<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addvideos extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	
	function getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype=null,$aclSelfPtype=null)
	{
		$query = new XiptQuery();
    	
    	return $query->select('COUNT(*)')
    				 ->from('#__community_videos')
    				 ->where(" `creator` = $resourceAccesser ", 'AND')
    				 ->where(" `published` = '1' ", 'AND')
    				 ->where(" `status` = 'ready' ")
    				 ->dbLoadQuery("","")
    				 ->loadResult();
	}
	
	public function handleViolation($info)
	{
		if($info['task'] == 'ajaxlinkvideopreview')
		{
			$objResponse = new JAXResponse();	
			$objResponse->addScriptCall('__throwError', XiptText::_('YOU_ARE_NOT_ALLOWED_TO_PERFORM_THIS_ACTION'));
        	$objResponse->sendResponse();
		}
		//let parent handle it
		parent::handleViolation($info);
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('videos' != $data['view'])
			return false;

		if($data['task'] == 'ajaxaddvideo' || $data['task'] == 'ajaxuploadvideo' || $data['task'] == 'ajaxlinkvideopreview')
				return true;

		return false;
	}

}
