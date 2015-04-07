<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class likegroup extends XiptAclBase
{
	function getResourceOwner($data)
	{
		if($data['args'][0] == 'groups')
		{
			$groupId	= isset($data['args'][1]) ? $data['args'][1] : 0;
			$ownerid	= $this->getownerId($groupId);
		}
		else if($data['args'][0]=='photo')
		{
			$photoGroupId=$this->getPhotoGroupId($data['args'][1]);
			$ownerid	= $this->getownerId($photoGroupId);
		}
		else if($data['args'][0]=='videos')
		{
			$videoData=$this->getVideoData($data['args'][1]);
			$ownerid	= $videoData[1];
		}
		else if($data['args'][0]=='events')
		{
			$eventData=$this->getEventData($data['args'][1]);
			$ownerid	= $eventData[1];
		}
		else
		{
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
		if($data['option']!='com_community')
			return false;
			
		if($data['view']!='system')
			return false;

		// for group details
		if(in_array(strtolower($data['task']), array('ajaxlike', 'ajaxunlike'))){
			
			if($data['args'][0] == 'groups'){
				return true;
			}

			// for group photos
			if($data['args'][0] == 'photo'){
				$photoGroupId = $this->getPhotoGroupId($data['args'][1]);
				if($photoGroupId){
					return true;
				}
				return false;
			}

			// for group videos
			if($data['args'][0] == 'videos'){
				$videoData = $this->getVideoData($data['args'][1]);
				if($videoData[0] == 'group'){
					return true;
				}
				return false;
			}

			//for group events
			if($data['args'][0] == 'events'){
				$eventData = $this->getEventData($data['args'][1]);
				if($eventData[0] == 'group'){
					return true;
				}
				return false;
			}

			return false;
		}
		
		// for stream
		if(!in_array($data['task'], array('ajaxstreamunlike', 'ajaxstreamaddlike'))){
			return false;
		}
		
		$activityData	= $this->getActivityData($data['args'][0]);
		$groupId=$activityData->groupid;
				
		if($groupId){
			return true;
		}

		return false;
	}
	
	function getownerId($id)
    {
    	$query = new XiptQuery();
    	
    	return $query->select('ownerid')
    				 ->from('#__community_groups')
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
    
    function getPhotoGroupId($photoId)
    {
    	$photo=CFactory::getModel('photos');
    	$groupId=$photo->getPhotoGroupId($photoId);
    	return $groupId;
    }
    
    function getEventData($eventId)
    {
    	$query=new XiptQuery();  
    
    	$eventData= $query->select("type,creator")
    					 ->from('#__community_events') 
    					 ->where(" `id` = $eventId ")
    					 ->dbLoadQuery("","")
    					 ->loadRow();
    	return $eventData;   	
    }
    
    function getVideoData($videoId)
    {
    	$query = new XiptQuery();  
    
    	$videoData = $query->select("creator_type,creator")
    					   ->from('#__community_videos') 
    					   ->where(" `id` = $videoId ")
    					   ->dbLoadQuery("","")
    					   ->loadRow();
    	return $videoData;	
    }
}
