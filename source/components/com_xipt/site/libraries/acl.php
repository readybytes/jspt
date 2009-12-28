<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTLibraryAcl
{
	
	function performACLCheck($ajax=false, $callArray, $args)
	{
		$feature ='';
		$task	 ='';
		
		// depending upon call get feature and task, might be objectID
		if($ajax){
			$feature 	= JString::strtolower($callArray[0]);
			$task	 	= JString::strtolower($callArray[1]);
		}
		else{
			$feature 	=  JRequest::getCmd('view');
			$task 		=  JRequest::getCmd('task');
		}

		$userId 		= JFactory::getUser()->id;
		$viewuserid 	= JRequest::getVar('userid', 0 , 'GET');
			
		if(XiPTLibraryUtils::isAdmin($userId))
			return false;
		
		if(($feature && ($task || $viewuserid) && $userId)== false)
			return false;
			
		// resolve feature and task ==> into our aclFeature
		$aclViolatingRule= false;
		$aclFeature	= XiPTLibraryAcl::resolvePararmeters($feature, $task, $viewuserid, $args);
		
		//$mainframe->enqueueMessage("aclfeature = ".$aclFeature);
		
		// do acl check, is feature need to be checked ?
		if($aclFeature == false)
			return false;
		else
			$aclViolatingRule 	=	XiPTLibraryAcl::aclMicroCheck($userId,$aclFeature,$viewuserid);
			
		// if not violating any rule, just return else redirect/ajaxBlock and show message.
		if($aclViolatingRule == false)
			return false;
		
			
		XiPTLibraryAcl::aclCheckFailedBlockUser($ajax,$aclViolatingRule, $task);	
		return false;
	}
	
	function resolvePararmeters(&$feature, &$task, &$viewuserid = 0, &$args)
	{
		$task	= strtolower($task);
		// take care : compare to smallcaps task only
		if($feature == 'groups')
		{
			if($task=='create')
				return "aclFeatureCreateGroup";
				
			if($task=='ajaxshowjoingroup' || $task=='ajaxsavejoingroup')
				return "aclFeatureJoinGroup";
				
			return false;
		}
		
		if($feature == 'photos')
		{
			if($task=='uploader' || $task == 'jsonupload' || $task == 'addnewupload')
				return "aclFeatureAddPhotos";
				
			if($task=='newalbum')
				return "aclFeatureAddAlbum";
				
			return false;
		}
		
		if($feature == 'videos')
		{
			if($task=='ajaxaddvideo' || $task == 'ajaxuploadvideo')
				return "aclFeatureAddVideos";
				
			return false;
		}
				
		if($feature=='inbox')
		{
			if($task == 'ajaxcompose' || $task == 'ajaxaddreply' || $task == 'write')
			{
				//modify whom we are sending msg
				$viewuserid = $args[0];
				return  "aclFeatureWriteMessages";
			}
			
			return false;
		}
		
		if($feature =='profile') {
			if($task=='uploadavatar')
				return "aclFeatureChangeAvatar";
				
			if($task=='privacy')
				return "aclFeatureChangePrivacy";
			
			if($viewuserid != 0 && $task=='')
				return "aclFeatureCantVisitOtherProfile";
	
			if($task=='edit')
				return "aclFeatureEditProfile";
				
			if($task=='editdetails')
				return "aclFeatureEditProfileDetail";
		}
			
		return false;
	}
	
	function aclCheckFailedBlockUser($ajax, $aclViolatingRule, $task)
	{
		$db		 =& JFactory::getDBO();
		
		// get all rules specific to user or his profiletype
		$query	 = 'SELECT * FROM #__xipt_aclrules '
					. ' WHERE id=' 	. $db->Quote($aclViolatingRule);
		
		$db->setQuery( $query );
		$result	= $db->loadObject();
		
		assert($result);
		
		//foreach($results as $result)
		//{
			$message	= $result->message;
			$redirect	= CRoute::_( $result->redirecturl,false );
		//}
		
		//TODO replace few KEYS in message - e.g. __TASKCOUNT__
		if($ajax)
			XiPTLibraryAcl::aclAjaxBlock($message,$redirect);
		else
		{
			// one special case
			if($task == 'jsonupload')
			{
				$nextUpload	= JRequest::getVar('nextupload' , '' , 'GET');
						echo 	"{\n";
						echo "error: 'true',\n";
						echo "msg: '" . $message . "'\n,";
						echo "nextupload: '" . $nextUpload . "'\n";
						echo "}";
				exit;
			}
			global $mainframe;
			$mainframe->enqueueMessage($message);
			$mainframe->redirect($redirect);
		}
	}
	

	function aclAjaxBlock($msg)
	{
		$objResponse   	= new JAXResponse();
		$uri			= CFactory::getLastURI();
		$uri			= base64_encode($uri);

		$html 	= $msg;

		$objResponse->addAssign('cwin_logo', 'innerHTML', JText::_('CC JSPTACL YOU ARE NOT ALLOWED TO PERFORM THIS ACTION'));
		$objResponse->addAssign('cWindowContent', 'innerHTML', $html);
		$objResponse->addScriptCall('cWindowResize', 80);
		$objResponse->sendResponse();
	}
	
	// final aclChecking
	function aclMicroCheck($userID , $feature , $viewuserid = 0,$objectID = 0)
	{
		// get profiletype
		assert($feature && $userID);
		
		$myPID	 = XiPTLibraryProfiletypes::getUserData($userID,'PROFILETYPE');
		$db		 = JFactory::getDBO();
		
		//is this require to check if viewuserid and userid is same
		//then user can visit their own profile or not
		if($viewuserid)
			$otherpid	= XiPTLibraryProfiletypes::getUserData($viewuserid,'PROFILETYPE');
		else
			$otherpid 	= 0;
		
		// get all rules specific to user or his profiletype
		//TODO : sort as per ascending task count.
		$extraSql	= '';
		if($feature == 'aclFeatureCantVisitOtherProfile' || $feature == 'aclFeatureWriteMessages'){
			//support for All Feature through ( -1 )
			//We add -1 for all in admin
			$extraSql = ' AND ( '.$db->nameQuote('otherpid').'='. $db->Quote($otherpid)
						.' OR '.$db->nameQuote('otherpid').'='.$db->Quote(ALL).' )';
		}
			

		$query	 = 'SELECT * FROM #__xipt_aclrules '
					. ' WHERE '
					. ' ( '.$db->nameQuote('pid').'='. $db->Quote($myPID)
					. ' OR '.$db->nameQuote('pid').'='.$db->Quote(ALL). ' ) '
					.$extraSql
					. ' AND '.$db->nameQuote('feature').'='. $db->Quote($feature)
					. ' AND '.$db->nameQuote('published').'='.$db->Quote(1);
		
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
		// If no rule exist for the feature then allow the user
		if(!$results)
			return false;
		
		// get the user's count for this feature
		$owns		= XiPTLibraryAcl::aclGetUsersFeatureCounts($userID, $feature,$otherpid);
		
		// check for all possible given rules,
		// if any rule is violating, return the rules ID
		foreach($results as $row)
		{
			if($row->taskcount <= $owns)
					return $row->id;
		}
		
		// none of the rule is violating
		return false;
	}
	
	// Below function gives the COUNT's for
	// feature and associated user
	function aclGetUsersFeatureCounts($userid,$feature,$otherpid=-1)
	{
		$groupsModel	=& CFactory::getModel('groups');
		$photoModel		=& CFactory::getModel('photos');
		//$inboxModel		=& CFactory::getModel('inbox');
		switch($feature)
		{
			case 'aclFeatureJoinGroup' :
				return $groupsModel->getGroupsCount($userid);
				
			case 'aclFeatureCreateGroup' :
				$db		=& JFactory::getDBO();
				$query	= 'SELECT COUNT(*) FROM ' . $db->nameQuote( '#__community_groups' ) . ' '
							. 'WHERE ' . $db->nameQuote( 'ownerid' ) . '=' . $db->Quote( $userid );
				$db->setQuery( $query );
				return $db->loadResult();
				
			case 'aclFeatureChangeAvatar' 			:
			case 'aclFeatureEditProfile'  			:
			case 'aclFeatureEditProfileDetail' 		:
			case 'aclFeatureChangePrivacy'			:
			case 'aclFeatureCantVisitOtherProfile'	:
				return 100000;
				
			case 'aclFeatureAddAlbum' :
				// adding album  // return album counts
				$db		=& JFactory::getDBO();
				$query	= 'SELECT COUNT(*) '
					. ' FROM ' . $db->nameQuote( '#__community_photos_albums' )
					. ' WHERE creator=' . $db->Quote( $userid );
				
				$db->setQuery( $query );
				return $db->loadResult();
		
			case 'aclFeatureAddPhotos' :
				// Adding photo . It only blocks interface, we need to block Ajax Request also
				return $photoModel->getPhotosCount($userid);
			
			case 'aclFeatureAddVideos' :
				$db		=& JFactory::getDBO();
				$query  = "SELECT COUNT(*) FROM #__community_videos WHERE published='1' AND status='ready' ";
				$db->setQuery( $query );
				return $db->loadResult();

			case 'aclFeatureWriteMessages':
				return self::getTotalMessageSent($userid,$otherpid);
			
			default :
				assert(0);
				
		}
		return 0;
	}
	
	function getTotalMessageSent( $userId,$otherpid=-1 )
	{
		CFactory::load( 'helpers' , 'time' );
		$db			=& JFactory::getDBO();
		
		if($otherpid == -1)
		{
			$query	= 'SELECT COUNT(*) FROM ' . $db->nameQuote( '#__community_msg' ) . ' AS a '
					. 'WHERE a.from=' . $db->Quote( $userId ) . ' '
					. 'AND a.parent=a.id';
			
		}
		else
		{
			/*
			 *  SELECT * FROM  j214_community_msg_recepient as a 
			 *  		LEFT JOIN  j214_community_msg as b ON   
			 *  		LEFT JOIN  j214_xipt_users as c ON a.`to`=c.`userid` 
			 *  		WHERE a.`msg_from` = '82'   AND c.`profiletype`='1'
			 */
			$query = "SELECT COUNT(*) FROM #__community_msg_recepient as a "
					." 	LEFT JOIN #__community_msg as b ON b.`id` = a.`msg_id` "
					."  LEFT JOIN #__xipt_users as c 	ON a.`to`=c.`userid` "
					."  WHERE a.`msg_from` = '$userId'  AND c.`profiletype`='$otherpid'"
					; 
		}

		$db->setQuery( $query );
		$count		= $db->loadResult();
		return $count;
	}
	
}
