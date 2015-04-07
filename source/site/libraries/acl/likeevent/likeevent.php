<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class likeevent extends XiptAclBase
{
	function getResourceOwner($data)
	{
		if($data['args'][0] == 'events'){
			$eventId	= isset($data['args'][1]) ? $data['args'][1] : 0;
			$ownerid	= $this->getownerId($eventId);
		}else{
			$activityData  = $this->getActivityData($data['args'][0]);
			$ownerid	= $activityData->actor;
		}
		return $ownerid;
	}
	
	function aclAjaxBlock($msg, $objResponse=null)
	{
		$objResponse = new JAXResponse();
		$title		 = XiptText::_('CC_PROFILE_VIDEO');
		$objResponse->addScriptCall('cWindowShow', '', $title, 430, 80);
		return parent::aclAjaxBlock($msg, $objResponse);
	}  
	  
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option']){
			return false;
		}
		
		if('system' != $data['view']){
			return false;
		}
		
		// for event details
		if(in_array(strtolower($data['task']), array('ajaxlike', 'ajaxunlike')) 
			&& $data['args'][0] == 'events'){
			return true;
		}
		
		// for stream
		if(!in_array($data['task'], array('ajaxstreamunlike', 'ajaxstreamaddlike'))){
			return false;
		}
		
		$activityData	= $this->getActivityData($data['args'][0]);
		$app = $activityData->app;
				
		if($app == 'events' || $app == 'events.wall'){
			return true;
		}

		return false;
	}
	
	function getownerId($id)
    {
    	$query = new XiptQuery();
    	
    	return $query->select('creator')
    				 ->from('#__community_events')
    				 ->where(" `id` = $id ")
    				 ->dbLoadQuery("","")
    				 ->loadResult();
    }

	function getActivityData($activityId)
	{
		$activity	    = CFactory::getModel('activities');
		$activityData  = $activity->getActivity($activityId);
		return $activityData;
    }
}
