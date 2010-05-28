<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class addphotos extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{
		$count = $this->getFeatureCounts($data['userid']);
		$maxmimunCount = $this->aclparams->get('addphotos_limit',0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	
	function getFeatureCounts($userid)
	{
		$photoModel		=& CFactory::getModel('photos');
		return $photoModel->getPhotosCount($userid);
	}
	
	
	function checkAclAccesibility($data)
	{
		/*XITODO : we will expect that view and task should be given
		 * and from parsing we will find out that is this request for me
		 */ 
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('photos' != $data['view'])
			return false;
			
		if($data['task'] == 'uploader' 
			|| $data['task'] == 'jsonupload' 
				|| $data['task'] == 'addnewupload')
				return true;
				
		return false;
	}
	
}
