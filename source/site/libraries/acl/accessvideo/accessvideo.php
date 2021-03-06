<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessvideo extends XiptAclBase
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
		
		$query 		= new XiptQuery();
   
	    return $query->select('creator')
	    				 ->from('#__community_videos')
	    				 ->where(" id = $videoId ")
	    				 ->dbLoadQuery("","")
	    				 ->loadResult();
	}

	function checkAclApplicable(&$data)
	{
		/*XITODO : we will expect that vie task and should be given
		 * and from parsing we will find out that is this request for me
		 */
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('videos' != $data['view'])
			return false;

		//also restrict user when he is accesing video through activity stream
		if($data['task'] === 'video' || $data['task'] === 'ajaxshowvideowindow')
				return true;

		return false;
	}

}