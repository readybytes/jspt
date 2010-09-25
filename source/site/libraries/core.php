<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTFactory
{
    /* This classes required a object to be created first.*/
    function getLibraryPluginHandler()
    {
        static $instance =null;
        
        if($instance==null)
            $instance = new XiPTLibraryPluginHandler();
        
        return $instance;
    }
    
    function getLibraryAEC()
    {
        static $instance =null;
        
        if($instance==null)
            $instance = new XiPTLibraryAEC();
        
        return $instance;
    }
    
    function getXiPTUser($userid)
    {
        static $instance = array();
        
        if(!$userid)
            return null;
        
        if($instance[$userid])
            return $instance[$userid];
        
        require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models'.DS.'user.php';
        
        $instance[$userid] = new XiPTModelUser($userid);
        return $instance[$userid];
    }
}


/*
 * This class contains all logic for XIPT & JomSocial & Joomla Table Communication
 * */
class XiPTLibraryCore
{
	/*
	 * Create a fields object
	 * */
    function getFieldObject($fieldid)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT * FROM '
				. $db->nameQuote( '#__community_fields' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $fieldid );
		
		$db->setQuery( $query );
		$result	= $db->loadObject();
		
		return $result;
	}
	
    //    get required user info from community_users table
	function getUserDataFromCommunity($userid,$what)
	{
		XiPTLibraryUtils::XAssert(!empty($what));
		$db			=& JFactory::getDBO();
		$query	= 'SELECT '.$db->nameQuote($what).' FROM '
				. $db->nameQuote( '#__community_users' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'userid' ) . '=' . $db->Quote( $userid );
		
		$db->setQuery( $query );
		
		$result	= $db->loadResult();
		
		return $result;
	}
	
    /**
     * Save user's joomla-user-type
     * @param $userid
     * @param $newUsertype
     * @return true/false
     */
    function updateJoomlaUserType($userid, $newUsertype='')
	{
	    //do not change usertypes for admins
		if(XiPTLibraryUtils::isAdmin($userid)==true || (0 == $userid )||$newUsertype === 'None')
		    return false;

		self::reloadCUser($userid);
		
		$user 			=& CFactory::getUser($userid);
		$authorize		=& JFactory::getACL();
		$user->set('usertype',$newUsertype);
		$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
		
		if($user->save()){
			// The issue with JomSocial, enforce clean reload of user object
			//enforce JomSocial to clean cached user
        	self::reloadCUser($userid);	
		    return true;
		}
		
		// With CUSER->save() nothing is returned
		//JError::raiseError('XIPTERR', JText::_( $user->getError()));
		self::reloadCUser($userid);
		return true;
	}
	

	/**
	 * @param  $instance
	 * @return CConfig
	 */
	function updateCommunityConfig(&$instance)
	{
		// skip these calls from backend
		global $mainframe;
		if($mainframe->isAdmin())
			return true;
			
		$loggedInUser = JFactory::getUser();
		$pID = XiPTLibraryProfiletypes::getUserData($loggedInUser->id,'PROFILETYPE');
		
		if(JRequest :: getVar('view') === 'register'){
			$pluginHandler = XiPTFactory::getLibraryPluginHandler();
			$pID = $pluginHandler->getRegistrationPType();
		}
					
		
		XiPTLibraryUtils::XAssert($pID);
		$params = XiPTLibraryProfiletypes::getParams($pID);

		if($params)
		{		
			$allParams = $params->_registry['_default']['data']; 
			//$params->getParams();
			foreach($allParams as $key => $value)
				$instance->set($key,$value); 
		}

		//means guest is looking user profile ,
		// so we will show them default template
		$visitingUser	= JRequest::getVar('userid',$loggedInUser->id);
	
		//$visitingUser = 0 means loggen-in-user is looking their own profile
		//so we set $visitingUser as logged-in-user
			//if in case user is already logged in
			//then honour his template else return and honour global settings
		if($visitingUser <= 0  || $visitingUser == '0')
			return true;
				
		//$visitingUser > 0 means a valid-user to visit profile
		//so we will show them profile in user template
		//so update the template in configuration	
		$template = XiPTLibraryProfiletypes::getUserData($visitingUser,'TEMPLATE');

		//now update template @template
		if($template) $instance->set('template',$template);
		return true;
	}
	
	function updateCommunityCustomField($userId, $value, $what='')
	{
	    //ensure we are calling it for correct field
	    XiPTLibraryUtils::XAssert($what == PROFILETYPE_CUSTOM_FIELD_CODE || $what == TEMPLATE_CUSTOM_FIELD_CODE);

	    // find the profiletype or template field
	    //TODO : user $user->setInfo, once it comes or some other way,
	    // dont patch up the database.
		$db		=& JFactory::getDBO();
		$query 	= 'SELECT * FROM `#__community_fields`'
				 .' WHERE '.$db->nameQuote('fieldcode').'='.$db->Quote($what);
		$db->setQuery( $query );
		$res = $db->loadObject();
		
		$field_id = $res->id;
		// skip these calls from backend
		XiPTLibraryUtils::XAssert($res) || JError::raiseError('REQ_CUST_FIELD',sprintf(JText::_('PLEASE CREATE CUSTOM FIELD FOR PROPER WORK'),$what));
		
		//if row does not exist
		$db		=& JFactory::getDBO();
		$query 	= ' SELECT * FROM '.$db->nameQuote('#__community_fields_values')
				 .' WHERE ' .$db->nameQuote('user_id'). '='.$db->Quote($userId)
				 .' AND '   .$db->nameQuote('field_id').'='.$db->Quote($field_id);
		$db->setQuery( $query );
		$res = $db->loadObject();

		//record does not exist, insert it
		if(!$res)
		{
			$res= new stdClass();
			$res->user_id = $userId;
			$res->field_id = $field_id;
			$res->value = $value;
			$db->insertObject('#__community_fields_values',$res,'id');
			
			if($db->getErrorNum()){
					JError::raiseError( 500, $db->stderr());
			}
			
			return true;
		}
		
		// change the type
		$res->user_id = $userId;
		$res->field_id = $field_id;
		$res->value = $value;
		$db->updateObject( '#__community_fields_values', $res, 'id');
		
		if($db->getErrorNum()){
				JError::raiseError( 500, $db->stderr());
		}
		
		return true;
	}
	
	/**
	 * This function add's given watermark to avatars
	 * 	IMP : If avatar, is default (JomSocil default or profiletypes default)
	 * 	then no action is taken
	 * 
	 * @param $userid
	 * @param $watermarkInfo
	 * @return unknown_type
	 */
	function updateCommunityUserWatermark($userid,$watermark='')
	{
		//no watermark
		if($watermark === '')
			return false;
			
		//check if watermark is enable
		if(XiPTLibraryUtils::getParams('show_watermark')=== false)
			return false;
		
		//update watermark on user's avatar
		$pTypeAvatar  	   = XiPTLibraryCore::getUserDataFromCommunity($userid, 'avatar');
		$pTypeThumbAvatar  = XiPTLibraryCore::getUserDataFromCommunity($userid, 'thumb');
		$isDefault		   = XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($pTypeAvatar,true);
		
		//no watermark
		if($watermark=='')	
		{
			XiPTLibraryCore::replaceAvatar($pTypeAvatar);
			XiPTLibraryCore::replaceAvatar($pTypeThumbAvatar);
		}
		
		// no watermark on default avatars
		if($isDefault)
			return false;
				
		//add watermark on user avatar image
		if($pTypeAvatar)
			XiPTLibraryUtils::addWatermarkOnAvatar($userid,$pTypeAvatar,$watermark,'avatar');

		//add watermark on thumb image
		if($pTypeThumbAvatar)
			XiPTLibraryUtils::addWatermarkOnAvatar($userid,$pTypeThumbAvatar,$watermark,'thumb');

		return true;
	}
	
	function replaceAvatar($imagepath)
	{
		    $avatarFileName = JFile::getName($imagepath);
			if(JFile::exists(USER_AVATAR_BACKUP.DS.$avatarFileName))
			JFile::copy(USER_AVATAR_BACKUP.DS.$avatarFileName,JPATH_ROOT.DS.$imagepath);
	}
	/**
	 * It updates user's oldAvtar to newAvatars
	 * @param $userid
	 * @param $newAvatar
	 * @return unknown_type
	 */
	function updateCommunityUserAvatar($userid, $newAvatar)
	{
		/*
		 * IMP : Implemented in setup 
		 * we migrate profiletype avatars to profiletype-1, 2 etc.
		 * So that we do not need to tense about old avatar of profiletype
		 * */
		
		//reload : so that we do not override previous information if any updated in database.
		self::reloadCUser($userid);
		$user    =& CFactory::getUser($userid);
		$userAvatar  = $user->_avatar;
		
		//We must enforce this as we never want to overwrite a custom avatar
		$isDefault	= XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($userAvatar,true);
		$changeAvatarOnSyncUp= self::_changeAvatarOnSyncUp($userAvatar); 
		
		if($isDefault==false && $changeAvatarOnSyncUp==false)
			return false;

		// we can safely update avatar so perform the operation		
		$user->set('_avatar',$newAvatar);
		$user->set('_thumb', XiPTLibraryUtils::getThumbAvatarFromFull($newAvatar));
		
		if(!$user->save())
		    return false;
		
		//enforce JomSocial to clean cached user
        self::reloadCUser($userid);
        
        //apply watermark on user's avatar, as we are not updating custom avatar 
        // we are never going to apply watermark over here
        /*
        $profiletype = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
        $watermark 	 = XiPTLibraryProfiletypes::getProfiletypeData($profiletype,'watermark');
        self::updateCommunityUserWatermark($userid, $watermark);
        */
        
		return true;
	}

	
	/*This function set privacy for user as per his profiletype*/
	function updateCommunityUserPrivacy($userid,$myprivacy)
	{	
		// get params
		self::reloadCUser($userid);
		
		$cuser    =& CFactory::getUser($userid);
		$myparams =  $cuser->getParams();
		foreach( $myprivacy as $key => $val ){
			$myparams->set( $key , $val );
		}

		if(!$cuser->save( 'params' ))
			return false ;

		 //enforce JomSocial to clean cached user
   		self::reloadCUser($userid);	
		return true;
		
	}
	
	function updateCommunityUserGroup($userId,$oldGroup, $newGroup)
	{
		// remove from oldGroup
		if($oldGroup && self::_isMemberOfGroup($userId,$oldGroup))
			XiPTLibraryCore::_removeUserFromGroup($userId,$oldGroup);
		
		// add to newGroup
        if($newGroup && self::_isMemberOfGroup($userId,$newGroup)==false)
        	XiPTLibraryCore::_addUserToGroup($userId,$newGroup);
       
		// add to new group
		return true;
	}
	
	function _isMemberOfGroup($userid, $groupid)
	{
		$db		=& JFactory::getDBO();
		$query	= " SELECT `memberid` FROM `#__community_groups_members` "
  				. " WHERE `memberid`='".$userid."'   AND `groupid` IN ({$groupid})" 
  				. " LIMIT 1";
  		$db->setQuery($query);
  		return $db->loadResult() ? true : false ;
	}
	
	function _addUserToGroup( $userId , $groupId)
	{
		$groupId=explode(',',$groupId);
		$groupModel	=& CFactory::getModel( 'groups' );
		//$userModel	=& CFactory::getModel( 'user' );
	
        //if user has selected "none" jst exit
		if(!is_array($groupId) || !count($groupId)>0 || in_array(0,$groupId))
			return false;
	
	    foreach($groupId as $k=>$gid)
	    {
			if( $groupModel->isMember( $userId , $gid ) )
				return false;
			
			$group		=& JTable::getInstance( 'Group' , 'CTable' );
			$member		=& JTable::getInstance( 'GroupMembers' , 'CTable' );
			$group->load( $gid );
			
			// Set the properties for the members table
			$member->groupid	= $group->id;
			$member->memberid	= $userId;
	
			// @rule: If approvals is required, set the approved status accordingly.
			$member->approved	= 1; // SHOULD BE always 1  by SHYAM//( $group->approvals ) ? '0' : 1;
	
			//@todo: need to set the privileges
			$member->permissions	= '0';
			$store	= $member->store();
	
			// Add XiPTLibraryUtils::XAssertion if storing fails
			XiPTLibraryUtils::XAssert( $store );
	
			if($member->approved)
				$groupModel->addMembersCount($gid);
			   
	        }
			return true;
	}
	    
	function _removeUserFromGroup($userId , $groupId)
	{
		$groupId=explode(',',$groupId);
		$model		= & CFactory::getModel( 'groups' );
		$group		=& JTable::getInstance( 'Group' , 'CTable' );
		
		//if(!$groupId)
		if((!is_array($groupId) )&& (!count($groupId)>0))
			return false;

	    foreach($groupId as $k=>$gid)
	    {
			$group->load( $gid );
		
			// do not remove owner
			if($group->ownerid == $userId)
				return;
			
			// is not already a member
			if(!$model->isMember($userId , $gid))
				return;
			
			// remove
			$groupMember	=& JTable::getInstance( 'GroupMembers' , 'CTable' );
			$groupMember->load( $userId , $gid );
	
			$data		= new stdClass();
			$data->groupid	= $gid;
			$data->memberid	= $userId;
	
			$model->removeMember($data);
			$model->substractMembersCount( $gid );
	    }
		return;
	}
	
	function reloadCUser($userid)
	{
		if(!$userid)
			return;
		
		$cuser =& CFactory::getUser($userid);
		$cuser = array();
		CFactory::getUser($userid);
		return;	
	}
	
	
	function _changeAvatarOnSyncUp($userAvatar)
	{
		$task=JRequest::getVar('task','','GET');
		if($task != 'syncUpUserPT')
			return false;
		$val=JString::stristr($userAvatar,PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.'avatar_');
		if($val==true)
			return true;
		return false;
	}
}
