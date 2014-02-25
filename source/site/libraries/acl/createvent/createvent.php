<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class createvent extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}

	function checkAclViolation($data)
	{
		$resourceAccesser 	= $this->getResourceAccesser($data);
		
		$maxmimunCount = $this->aclparams->getValue('createvent_limit',null,0);
		$aclgroup 	   = $this->aclparams->getValue('event_category');
		if($aclgroup){
			if($data['ajax']){
				$args		= $data['args'];
				$eventData	= json_decode($args[1]);
				$catId		= $eventData->catid;
			}
			else{
				$catId		   = JRequest::getVar('catid' , 0 , 'REQUEST');
			}
		}
		else 
			$catId		   = JRequest::getVar('catid' , $aclgroup , 'REQUEST');
		
		$count = $this->getFeatureCounts($resourceAccesser,$catId);
		
		if ($aclgroup === $catId && $count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	function checkAclViolationByPlan($data)
	{
		return $this->checkAclViolation($data);
	}
	
	function getFeatureCounts($resourceAccesser,$catId,$otherptype=null,$aclSelfPtype=null)
	{
		if($catId)
			$condition = "AND `catid`= $catId";
		else
			$condition = '';
			
		$query = new XiptQuery();
   
    	return $query->select('COUNT(*)')
    				 ->from('#__community_events')
    				 ->where(" `creator` = $resourceAccesser $condition ")
    				 ->dbLoadQuery("","")
    				 ->loadResult();
		
	}


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if($data['view'] != 'events' && $data['view'] != 'system')
			return false;

		// XITODO : use pattern ( return false in below conditiion)
		if($data['task'] == 'create')
			return true;

		$args		= $data['args'];
		$eventData	= json_decode($args[1]);
		
		if($data['task'] == 'ajaxstreamadd' && $eventData->type == 'event')
			return true;
			
		return false;
	}

}