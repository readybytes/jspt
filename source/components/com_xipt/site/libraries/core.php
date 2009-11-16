<?php
/**
 */

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
        
        $instance   = new XiPTModelUser($userid);
            
            
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
		assert(!empty($what));
		$db			=& JFactory::getDBO();
		$query	= 'SELECT '.$db->nameQuote($what).' FROM '
				. $db->nameQuote( '#__community_users' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'userid' ) . '=' . $db->Quote( $userid );
		
		$db->setQuery( $query );
		
		$result	= $db->loadResult();
		
		return $result;
	}
	
/*
     * Save user's joomla-user-type
     * */
    function updateJoomlaUserType($userid,$profiletypeId)
	{
	    //do not change usertypes for admins
		if(XiPTLibraryUtils::isAdmin($userid)==true || (0 == $userid ))
		    return false;

		$user 			= clone(JFactory::getUser($userid));
		$authorize		=& JFactory::getACL();
		
		$newUsertype = XiPTLibraryProfiletypes::getProfileTypeData($profiletypeId,'jusertype');
		$user->set('usertype',$newUsertype);
		$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
		
		if($user->save())
		    return true;

		// Error
		JError::raiseWarning('', JText::_( $user->getError()));
		return false;
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
			return;
		$loggedInUser 		= JFactory::getUser();
		
		//means guest is looking user profile ,
		// so we will show them default template
		if(!$loggedInUser->id)
			return true;
			
		$visitingUser	= JRequest::getVar('userid','NOT','GET');
		//$visitingUser = 0 means loggen-in-user is looking their own profile
		//so we set $visitingUser as logged-in-user
		if($visitingUser == 'NOT' || $visitingUser == '0')
				$visitingUser= $loggedInUser->id;
		
		//$visitingUser > 0 means a valid-user to visit profile
		//so we will show them profile in user template
		//so update the template in configuration
		if($visitingUser > 0) {
			$template = XiPTLibraryProfiletypes::getUserData($visitingUser,'TEMPLATE');
			//now update template @template
			if($template) {
				$instance->set('template',$template);
			}
		}
		
		return true;
	}
	
	function updateCommunityCustomField($userId, $value,$what='')
	{
	    //ensure we are calling it for correct field
	    assert($what == PROFILETYPE_CUSTOM_FIELD_CODE || $what == TEMPLATE_CUSTOM_FIELD_CODE);

	    // find the profiletype or template field
	    //TODO : user $user->setInfo, once it comes or some other way,
	    // dont patch up the database.
		$db		=& JFactory::getDBO();
		$query 	= 'SELECT * FROM `#__community_fields`'
				 .' WHERE '.$db->nameQuote('fieldcode').'='.$db->Quote($what);
		$db->setQuery( $query );
		$res = $db->loadObject();

		// skip these calls from backend
		assert($res) || JError::raiseError('REQ_CUST_FIELD',sprintf(JText::_('PLEASE CREATE CUSTOM FIELD FOR PROPER WORK'),$what));
		
		// change the type
		$id	= $res->id;
		$strSQL	= ' UPDATE '.$db->nameQuote('#__community_fields_values')
				. ' SET '   .$db->nameQuote('value').   '='.$db->Quote($value)
				. ' WHERE ' .$db->nameQuote('user_id'). '='.$db->Quote($userId)
				. ' AND '   .$db->nameQuote('field_id').'='.$db->Quote($id);
		$db->setQuery( $strSQL );
		$db->query();
		
		return true;
	}
	
	function updateCommunityUserAvatar($userid,$profiletypeID)
	{
		//TODO : CODREV: We must enforce this as we never want
		// to overwrite a custom avatar
		if(!XiPTLibraryProfiletypes::isProfileTypeDataResetRequired($userid,'avatar','profiletype'))
			return false;

		// we can safely update avatar
		$pTypeAvatar 	  = XiPTLibraryProfiletypes::getProfileTypeData($profiletypeID,'avatar');
		$pTypeThumbAvatar = XiPTLibraryUtils::getThumbAvatarFromFull($pTypeAvatar);

		// perform the operation
		$user    =&  CFactory::getUser($userid);
		$user->set('_avatar',$pTypeAvatar);
		$user->set('_thumb', $pTypeThumbAvatar);
		
		if(!$user->save())
		    return false;
		
		//enforce JomSocial to clean cached user
        $user    =     array();
		$user    =&  CFactory::getUser($userid);
		return true;
	}

	/*This function set privacy for user as per his profiletype*/
	function updateCommunityUserPrivacy($userid,$profiletypeId)
	{
		
		$privacy 	= XiPTLibraryProfiletypes::getProfileTypeData($profiletypeId,'privacy');
		$myprivacy	= XiPTLibraryUtils::getPTPrivacyValue($privacy);
		
		// get params
		$cuser    =&  CFactory::getUser($userid);
		$myparams = $cuser->getParams();
		$myparams->set('privacyProfileView',$myprivacy);
		
        if(!$cuser->save())
            return false;
        
        //enforce JomSocial to clean cached user
        $user    =     array();
		$user    =&  CFactory::getUser($userid);
 		return true;
	}
	
	function updateCommunityUserGroup($userId,$profileTypeId, $oldProfileTypeId )
	{
		$oldGroup = XiPTLibraryProfiletypes::getProfileTypeData($oldProfileTypeId,'group');
        $newGroup = XiPTLibraryProfiletypes::getProfileTypeData($profileTypeId,'group');
        
        if($oldGroup == $newGroup)
            return;
            
		// if user is changing profiletype then remove it from other group
		if($oldProfileTypeId != $profileTypeId)
			XiPTLibraryCore::_removeUserFromGroup($userId,$oldGroup);
		
		// add to new group
		XiPTLibraryCore::_addUserToGroup($userId,$newGroup);
	}
	
	
	function _addUserToGroup( $userId , $groupId)
	{
		$groupModel	=& CFactory::getModel( 'groups' );
		$userModel	=& CFactory::getModel( 'user' );
	
		if(!$groupId)
			return false;
	
		if( $groupModel->isMember( $userId , $groupId ) )
			return false;
		else
		{
			$group		=& JTable::getInstance( 'Group' , 'CTable' );
			$member		=& JTable::getInstance( 'GroupMembers' , 'CTable' );
			$group->load( $groupId );
			
			// Set the properties for the members table
			$member->groupid	= $group->id;
			$member->memberid	= $userId;
	
			// @rule: If approvals is required, set the approved status accordingly.
			$member->approved	= 1; // SHOULD BE always 1  by SHYAM//( $group->approvals ) ? '0' : 1;
	
			//@todo: need to set the privileges
			$member->permissions	= '0';
			$store	= $member->store();
	
			// Add assertion if storing fails
			CError::assert( $store , true , 'eq' , __FILE__ , __LINE__ );
	
			if($member->approved)
				$groupModel->addMembersCount($groupId);
			return true;
		}
		return false;
	}
	    
	function _removeUserFromGroup($userId , $groupId)
	{
		$model		= & CFactory::getModel( 'groups' );
		$group		=& JTable::getInstance( 'Group' , 'CTable' );
		
		if(!$groupId)
			return;
		
		$group->load( $groupId );
		
		// do not remove owner
		if($group->ownerid == $userId)
			return;
			
		// is not already a member
		if(!$model->isMember($userId , $groupId))
			return;
			
		// remove
		$groupMember	=& JTable::getInstance( 'GroupMembers' , 'CTable' );
		$groupMember->load( $userId , $groupId );
	
		$data		= new stdClass();
		$data->groupid	= $groupId;
		$data->memberid	= $userId;
	
		$model->removeMember($data);
		$model->substractMembersCount( $groupId );
		
		return;
	}
}
