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
		return $data['userid'];
	}
	
	function checkAclViolation(&$data)
	{	
		$resourceAccesser 	= XiptAclBase::getResourceAccesser($data);		
		
		if(XiptAclBase::isApplicableOnSelfProfiletype($resourceAccesser) === false)
			return true; 
		
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
		
		$allowedCats = $this->aclparams->get('video_category');
		
		//$allowedCats ==0 means user can access all categories
		if($allowedCats == 0)
			return true;
			
		//check if its applicable on more than 1 category
		$allowedCats = is_array($allowedCats) ? $allowedCats : array($allowedCats);
		
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
		$videoId	= isset($videoId)? $videoId : $args[0];
		$db 		= JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('category_id')
						.' FROM '.$db->nameQuote('#__community_videos')
						.' WHERE '.$db->nameQuote('id').' = '.$db->Quote($videoId);

		$db->setQuery( $query );
		$catId = $db->loadResult();
		
		if(!$catId)
			return false;
		
		if(in_array($catId, $allowedCats))
			return true;
			
		return false;
	}
	
}
