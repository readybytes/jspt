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
			$ownerid	= $activityData['actor'];
		}
		return $ownerid;
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
		
				
		// if user tries to like any comment on photo
		if(count($data['args']) > 1)
		{
			// Check if acl is applicable on comments also
			if(($data['args'][1] == 'comment') && ($this->aclparams->getValue('acl_applicable_on_comments',null,0) == false)){
				return false;
			}

			$activityId = $this->getActivityId($data['args'][0]);
		}
		else
		{
			$activityId	= $data['args'][0];
		}
		
		$activityData	= $this->getActivityData($activityId);
		$app = $activityData['app'];
				
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
		$query = new XiptQuery();
    	
    	return $query->select('*')
    				 ->from('#__community_activities')
    				 ->where(" `id` = $activityId ")
    				 ->dbLoadQuery("","")
    				 ->loadAssoc();
    }
    
	function getActivityId($commentId)
    {
    	$query = new XiptQuery();
    	
    	return $query->select('contentid')
    				 ->from('#__community_wall')
    				 ->where("id = $commentId")
    				 ->dbLoadQuery("","")
    				 ->loadResult();
    }
}
