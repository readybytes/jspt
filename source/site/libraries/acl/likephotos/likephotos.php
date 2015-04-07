<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class likephotos extends XiptAclBase
{
	function getResourceOwner($data)
	{
		if($data['args'][0] == 'photo'){
			$photoId	= isset($data['args'][1]) ? $data['args'][1] : 0;
			$ownerid	= $this->getownerId($photoId);
		}else{
			$activityData  = $this->getActivityData($data['args'][0]);
			$ownerid	= $activityData->actor;
		}
		return $ownerid;
	}
	
	function aclAjaxBlock($msg, $objResponse=null)
	{
		$objResponse = new JAXResponse();
		$title		 = XiptText::_('CC PROFILE VIDEO');
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
		
		// for photo details popup
		if(in_array(strtolower($data['task']), array('ajaxlike', 'ajaxunlike')) 
			&& $data['args'][0] == 'photo'){
			return true;
		}
		
		// for stream
		if(!in_array($data['task'], array('ajaxstreamunlike', 'ajaxstreamaddlike'))){
			return false;
		}
		
		$activityData	= $this->getActivityData($data['args'][0]);
		$app = $activityData->app;
				
		if($app=='photos'){
			return true;
		}

		return false;
	}
	
	function getownerId($id)
    {
    	$query = new XiptQuery();
    	
    	return $query->select('creator')
    				 ->from('#__community_photos')
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
