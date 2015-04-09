<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class likegroup extends XiptAclBase
{
	function getResourceOwner($data)
	{
		switch ($data['args'][0])
		{
			case 'groups' :
				$groupId	= isset($data['args'][1]) ? $data['args'][1] : 0;
				$ownerid	= $this->getownerId($groupId);
				break;
			
			case 'photo'  :
				$photoGroupId=$this->getPhotoGroupId($data['args'][1]);
				$ownerid	= $this->getownerId($photoGroupId);
				break;
				
			case 'videos' :
				$videoData=$this->getVideoData($data['args'][1]);
				$ownerid	= $videoData[1];
				break;
				
			case 'events' :
				$eventData=$this->getEventData($data['args'][1]);
				$ownerid	= $eventData[1];
				break;
				
			default       :
				$activityData  = $this->getActivityData($data['args'][0]);
				$ownerid	= $activityData['actor'];
				break;
		}

		return $ownerid;
	}
	  
	function checkAclApplicable(&$data)
	{
		if($data['option']!='com_community')
			return false;
			
		if($data['view']!='system')
			return false;

		// for group details
		if(in_array(strtolower($data['task']), array('ajaxlike', 'ajaxunlike'))){
			
			switch($data['args'][0])
			{
				case 'groups' 	:
					return true;
					
				// for group photos
				case 'photo'  	:
					// Check if acl is applicable on group photos also
					if($this->aclparams->getValue('acl_applicable_on_group_photos',null,0) == false){
						return false;
					}
					$photoGroupId = $this->getPhotoGroupId($data['args'][1]);
					if($photoGroupId){
						return true;
					}
					return false;

				// for group videos
				case 'videos' 	:
					// Check if acl is applicable on group videos also
					if($this->aclparams->getValue('acl_applicable_on_group_videos',null,0) == false){
						return false;
					}
					$videoData = $this->getVideoData($data['args'][1]);
					if($videoData[0] == 'group'){
						return true;
					}
					return false;

				// for group events
				case 'events'	:
					// Check if acl is applicable on group events also
					if($this->aclparams->getValue('acl_applicable_on_group_events',null,0) == false){
						return false;
					}
					$eventData = $this->getEventData($data['args'][1]);
					if($eventData[0] == 'group'){
						return true;
					}
					return false;

				default 	 	:  
					return false;
			}
		}
		
		// for stream
		if(!in_array($data['task'], array('ajaxstreamunlike', 'ajaxstreamaddlike'))){
			return false;
		}
		
		$activityData	= $this->getActivityData($data['args'][0]);
		$groupId=$activityData['groupid'];
				
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
		$query = new XiptQuery();
    	
    	return $query->select('*')
    				 ->from('#__community_activities')
    				 ->where(" `id` = $activityId ")
    				 ->dbLoadQuery("","")
    				 ->loadAssoc();
    }
    
    function getPhotoGroupId($photoId)
    {
    	$query=new XiptQuery();  
    
    	return $query->select("groupid")
    					 ->from('#__community_photos_albums') 
    					 ->where(" `photoid` = $photoId ")
    					 ->dbLoadQuery("","")
    					 ->loadResult();
    }
    
    function getEventData($eventId)
    {
    	$query=new XiptQuery();  
    
    	return $query->select("type,creator")
    					 ->from('#__community_events') 
    					 ->where(" `id` = $eventId ")
    					 ->dbLoadQuery("","")
    					 ->loadRow();   	
    }
    
    function getVideoData($videoId)
    {
    	$query = new XiptQuery();  
    
    	return $query->select("creator_type,creator")
    					   ->from('#__community_videos') 
    					   ->where(" `id` = $videoId ")
    					   ->dbLoadQuery("","")
    					   ->loadRow();
    }
}
