<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class accessvideo extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{	
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		
		$videoId	= JRequest::getVar( 'videoid' , '' , 'get' );
		$video	    = & CFactory::getModel('videos');
		$videoData  = $video->getVideos(array('id'=>$videoId));
		$creatorid	= $videoData[0]->creator;
		
		$otherpid	= XiPTLibraryProfiletypes::getUserData($creatorid,'PROFILETYPE');
		
		
		if((0 != $otherptype)
			&& (-1 != $otherptype)
				 && ($otherpid != $otherptype))
			return false;
			
		
		if($this->aclparams->get('acl_applicable_to_friend',1) == 0)
		{
			$isFriend = XiPTHelperAclRules::isFriend($data['userid'],$data['viewuserid']);
			if($isFriend)
			 return false;
		}	
			
		return true;
	}
	
		
	function checkAclAccesibility(&$data)
	{
		/*XITODO : we will expect that vie task and should be given
		 * and from parsing we will find out that is this request for me
		 */ 
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('videos' != $data['view'])
			return false;
			
		if($data['task'] === 'video')
				return true;
				
		return false;
	}
	
}