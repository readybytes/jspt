<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessprofilevideo extends XiptAclBase
{
	function getResourceOwner($data)
	{
		if($data['viewuserid']){
			return $data['viewuserid'];
		}
		
		$videoId 	= $this->_getVideoId();
		$videoId	= empty($videoId)? $data['args'][0] : $videoId;
   	
		return $this->getownerId($videoId);
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option']){
			return false;
		}

		if('videos' != $data['view']){
			return false;
		}

		if($data['task'] != 'video'){
			return false;
		}
			
		$videoId = $this->_getVideoId();
		if($this->_isProfileVideo($videoId)){
			return true;
		}

		return false;
	}

	function getownerId($id)
    {
    	$query = new XiptQuery();
    	
    	return $query->select('creator')
    				 ->from('#__community_videos')
    				 ->where(" `id` = $id ")
    				 ->dbLoadQuery("","")
    				 ->loadResult();
    }

	/**
	 *  function to get videoId
     */
    protected function _getVideoId()
    {
		$videoId = JRequest::getVar( 'videoid' , 0);
		$conf    = JFactory::getConfig();

        // if sef is enabled then get actual video id
		if($conf->get('sef', false) == true && $videoId){
			$vId     = explode(":", $videoId);
			$videoId = $vId[0];
		}

		return $videoId;
    }

	/**
	 * function to check whether video is the profileVideo of resource owner
	 */
	protected function _isProfileVideo($videoId)
	{
		$query		= new XiptQuery();
		
		$ownerId 	= $this->getownerId($videoId);
		$params		= $query->select('params')
							->from('#__community_users')
							->where("userid = $ownerId")
							->dbLoadQuery("","")
							->loadResult();

		$userParams		= json_decode($params, true);
		$profileVideoId = $userParams['profileVideo'];
		
		if($profileVideoId == $videoId){
			return true;
		}
		return false;
	}

}
