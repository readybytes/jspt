<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addphotos extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}

	function getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype=null,$aclSelfPtype=null)
	{
		$photoModel		=& CFactory::getModel('photos');
		return $photoModel->getPhotosCount($resourceAccesser);
	}

	public function handleViolation($info)
	{
		$msg  = XiptText::_('YOU_ARE_NOT_ALLOWED_TO_PERFORM_THIS_ACTION');
		$task = array('ajaxpreview', 'jsonupload');
		
		if(in_array($info['task'], $task)){
			$nextUpload	= JRequest::getVar('nextupload');
			$json = new stdClass();
			$json->error = true;
			$json->thumbnail = false;
			$json->msg = $msg;
			$json->nextUpload = $nextUpload;
			echo json_encode($json);
			exit;
		}

		//let parent handle it
		parent::handleViolation($info);
	}


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
	
		if('photos' != $data['view'])
			return false;

		$task = array('uploader', 'jsonupload', 'addnewupload', 'ajaxpreview', 'ajaxuploadphoto', 'multiupload');
		if(in_array($data['task'], $task))
				return true;

		return false;
	}

}
