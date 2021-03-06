<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessphoto extends XiptAclBase
{
	function getResourceOwner($data)
	{
		if($data['viewuserid']){
			return $data['viewuserid'];
		}

		if(is_array($data['args'])){
			$albumId 	= $data['args'][0];

			$query 		= new XiptQuery();
   
	    	return $query->select('creator')
	    				 ->from('#__community_photos')
	    				 ->where(" albumid = $albumId ")
	    				 ->dbLoadQuery("","")
	    				 ->loadResult();	
		}

		return false;
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('photos' != $data['view'])
			return false;
		
		if($data['task'] !== 'ajaxgetphotosbyalbum' && $data['task'] !== 'photo' 
				&& $data['task'] !== 'myphotos' && $data['task'] != 'display')
			return false;

		return true;
	}
	
	function checkAclViolation($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
		
		//if user is accessing group albums' photo, dont restrict him
		if(!$resourceOwner)
			return false;
			
		if($this->isApplicableOnSelf($resourceAccesser,$resourceOwner) === false)
			return false;
		
		if($this->isApplicableOnSelfProfiletype($resourceAccesser) === false)
			return false;
		
		if($this->isApplicableOnOtherProfiletype($resourceOwner) === false)
			return false;
		
		//XITODO if allwoed to self
		
		
		// if resource owner is friend of resource accesser 
		if($this->isApplicableOnFriend($resourceAccesser,$resourceOwner) === false)
			return false; 
		
		// if feature count is greater then limit
		if($this->isApplicableOnMaxFeature($resourceAccesser,$resourceOwner, $data) === false)
			return false;
				
		return true;
	}
}
