<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessvideocategory extends XiptAclBase
{
	function getResourceOwner($data)
	{
		if($data['viewuserid'])
			return $data['viewuserid'];
		
		$videoId = isset($data['videoid']) ? $data['videoid'] : '';
		$videoId = JRequest::getVar( 'videoid' , $videoId );
		$conf    = JFactory::getConfig();
        // if sef is enabled then get actual video id
		if($conf->get('sef', false) == true && $videoId)
		{
			$vId     = explode(":", $videoId);
			$videoId = $vId[0];
			
		}
		$args		= $data['args'];
		$videoId	= empty($videoId)? $args[0] : $videoId;
		
		$video	    = CFactory::getModel('videos');
		$videoData  = $video->getVideos(array('id'=>$videoId));
		$creatorid	= $videoData[0]->creator;
		return $creatorid;
	}
	
	function checkAclViolation($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
		
		if($this->isApplicableOnSelf($resourceAccesser,$resourceOwner) === false)
			return false;
			
		if(XiptAclBase::isApplicableOnSelfProfiletype($resourceAccesser) === false)
			return true; 
		
		if($this->isApplicableOnFriend($resourceAccesser,$resourceOwner) === false)
			return false; 
			
		if($this->isApplicableForVideoCategory($data)=== true)
			return false;
				
		return true;
	}
	
	function checkAclViolationByPlan($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
		
		if($this->isApplicableOnSelf($resourceAccesser,$resourceOwner) === false)
			return false;
		
		if($this->isApplicableOnSelfPlan($resourceAccesser) === false)
			return false;
		
		// if resource owner is friend of resource accesser 
		if($this->isApplicableOnFriend($resourceAccesser,$resourceOwner) === false)
			return false; 
		
		if($this->isApplicableForVideoCategory($data)=== true)
			return false;
				
		return true;
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('videos' != $data['view'])
			return false;

		if($data['task'] === 'video' || $data['task'] === 'ajaxshowvideowindow' || $data['task'] == 'display')
				return true;

		return false;
	}
	
	function isApplicableForVideoCategory($data)
	{
		
		$allowedCats = $this->aclparams->getValue('video_category');
			
		//check if its applicable on more than 1 category
		$allowedCats = is_array($allowedCats) ? $allowedCats : array($allowedCats);
		
		//$allowedCats ==0 means user can access all categories
		if(in_array(0, $allowedCats))
			return true;
		
		//in case, he is accessing categories in videos >> all videos instead of directly accessing video
		if($data['task'] == 'display'){
			$catId	= JRequest::getVar('catid' , 0);
			
			//accessing all videos
			if(!$catId)
				return true;
			
			if(in_array($catId, $allowedCats))
				return true;
			
			return false;
		}
		
		$args		= $data['args'];
		$videoId	= JRequest::getVar('videoid' , 0, 'REQUEST');
		$videoId	= empty($videoId)? $args[0] : $videoId;
		$db 		= JFactory::getDBO();
		$query		= 'SELECT '.$db->quoteName('category_id')
						.' FROM '.$db->quoteName('#__community_videos')
						.' WHERE '.$db->quoteName('id').' = '.$db->Quote($videoId);

		$db->setQuery( $query );
		$catId = $db->loadResult();
		
		if(!$catId)
			return false;
		
		if(in_array($catId, $allowedCats))
			return true;
			
		return false;
	}
	
}
