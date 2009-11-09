<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTLibraryCore
{
	
	function isAdmin($id, $refID=0)
	{
		$acl  		= & JFactory::getACL();
		$objectID   = $acl->get_object_id( 'users', $id, 'ARO' );
		
		if(!$objectID)
			return false;
			
		$groups     = $acl->get_object_groups( $objectID, 'ARO' );
		
		if(!$groups)
			return false;
			
		$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
		//print_r("mygroup".$this_group. " my id ".$id);
		if($this_group == 'super administrator')
		{
			if($refID)
				return true;
			else
				return XiPTLibraryCore::isAdmin($refID) ? false : true;
				
		}
		return false;	
	}
	
	function checkEditAccessRight($myId, $calleId)
	{
		// Always I can edit my own profile
		if($myId ==  $calleId)
			return true;
			
		// are u superadmin or admin, 
		if(XiPTLibraryCore::isAdmin($myId, $calleId))
			return true;
    
		return false;
	}
	
	
	
	//update configuration before loading
	function changeConfiguration(&$instance)
	{
		$loggedInUser 		= JFactory::getUser();
		//means guest is looking user profile ,
		// so we will show them default template
		if(!$loggedInUser->id)
			return;
		$visitingUser	= JRequest::getVar('userid','NOT','GET');
		//$visitingUser = 0 means loggen-in-user is looking their own profile
		//so we set $visitingUser as logged-in-user
		if($visitingUser == 'NOT' || $visitingUser == '0')
				$visitingUser= $loggedInUser->id;
		
		//$visitingUser > 0 means a valid-user to visit profile
		//so we will show them profile in user template
		//so update the template in configuration
		if($visitingUser > 0) {
			$template = XiPTLibraryProfiletypes::getTemplateOfuser($visitingUser);
			//now update template @template
			if($template) {
				$instance->set('template',$template);
			}
				
		}
	}
	

	//TODO ( DONE ) : When user don't change his ptype then don't change his other settings.
	//function will call when value will be updated in community_fields_values table
	function updateProfileFieldsValueEvent($userId,$isNew,$fieldID,$value)
	{
		$fieldInfo = XiPTLibraryProfiletypes::getFieldInfofromFieldId($fieldID);
		if($fieldInfo->type == PROFILETYPE_FIELD_NAME) {
			//check that profiletype id is new or old one
			//if it's new then call reset functions else don't reset users all info
			$ptypeId = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($userId);
			if($ptypeId == $value)
				return ;

			XiPTLibraryCore::setProfileDataForUserID($userId,$value,'ALL');
		}	
		else if($fieldInfo->type == TEMPLATE_FIELD_NAME)
			XiPTLibraryProfiletypes::saveFieldForUser($userId,$value,TEMPLATE_FIELD_NAME);
		
		return;
	}
	
	
	function saveUser($userid,$profiletype,$template) 
	{
		
		//validate profiletype value
		if(!XiPTLibraryProfiletypes::validateProfiletypeId($profiletype))
			assert(1) || JError::raiseWarning('NOVALIDPTYPE',JText::_("INVALID PROFILETYPE"));
			
		assert($userid);
		assert($profiletype);
		assert(!empty($template));
		
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models'.DS.'user.php');
		$data = new stdClass();
		$data->userid = $userid;
		$data->profiletype = $profiletype;
		$data->template = $template;
		XiPTModelUser::setUserData($data);
	}
	
	
	function saveUserTypeinUser($userid,$profiletypeId)
	{
		
		if(XiPTLibraryCore::isAdmin($userid)==false) {
				
				$user 			= clone(JFactory::getUser($userid));		
				$authorize		=& JFactory::getACL();
				
				$newUsertype = XiPTLibraryProfiletypes::getProfileTypeData($profiletypeId,'jusertype');
				$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
				if ( !$user->save() )
				{
					JError::raiseWarning('', JText::_( $user->getError()));
					return false;
				}
		}
			
	}
	
	
	
	// ALL means you are from register
	function setProfileDataForUserID($userid, $ptype, $what='ALL') 
	{
		//during registration
		if($what == 'ALL') {
			//1.set profiletype and template for user in #__xipt_users table
			$template = XiPTLibraryProfiletypes::getProfileTypeData($ptype,'template');
			XiPTLibraryCore::saveUser($userid,$ptype,$template);
			
			//2.set usertype acc to profiletype in #__user table
			XiPTLibraryCore::saveUserTypeinUser($userid,$ptype);
			
			//3.set user avatar in #__community_users table
			XiPTLibraryProfiletypes::updateAvatarinCommunityUser($userid,$ptype);
			
			//4.set profiletype and template field in #__community_fields_values table
			// also change the user's type in profiletype field.
			XiPTLibraryProfiletypes::setCustomField($userid,$ptype,PROFILETYPE_FIELD_NAME);
			//set template
			XiPTLibraryProfiletypes::setCustomField($userid,$template,TEMPLATE_FIELD_NAME);
			
			// assign the default group  
			XiPTLibraryProfiletypes::assignUserToGroup($userid,$ptype);
			
			//5.set privacy data
			XiPTLibraryProfiletypes::updatePrivacyforCommunityUser($userid,$ptype);
	
			//Reseting user already loaded information , 
			//bcoz JS collects all data in static array when system load
			//so it don't load profile data again , just load previous loaded data
			//so our effect will not reflect ( avatar , privacy etc. )
			//so for showing it's effect we have clear the user ( user is refrence )
			//so by clearing we have cleared loaded data
			//after again initializinng we have again loaded our data		
			$user	=& CFactory::getUser($userid);
			$user	= array();
			$user	=& CFactory::getUser($userid);
		}
	}
	
	//call fn to get fields related to ptype in getviewable and geteditable profile fn
	function getFieldsInEditMode($userid,&$fields)
	{
		$pTypeID = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($userid);
		assert($pTypeID) || JError::raiseError('PTYWAR',(JText::_("NO PROFILETYPE SET")));
		XiPTLibraryProfiletypes::getProfiletypeFieldsinEditMode($fields,$pTypeID);
	}
	
	
	
	//show fields according to profiletype during registration
	function getFieldsDuringRegistration(&$fields)
	{
		//get profieltype value from session 
		$mySess = & JFactory::getSession();
		$selectedProfiletypeID = 0;
		if($mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
			&& (($selectedProfiletypeID = $mySess->get('SELECTED_PROFILETYPE_ID',0, 'XIPT'))
				 != 0)) {
						XiPTLibraryProfiletypes::getProfiletypeFields($fields,$selectedProfiletypeID);
		}
		assert($selectedProfiletypeID)|| JError::raiseError('PTYERR',JText::_('PLEASE ASK ADMIN TO SET DEFAULT PROFILETYPE THROUGH ADMIN PANEL OTHERWISE THING WILL NOT WORK PROPERLY'));
	}
	
	

	function canEditMe($myId, $calleId)
	{
		return XiPTLibraryCore::checkEditAccessRight($myId, $calleId);
	}
	
	 
	
	
	
	
	function getEditInfo()
	{
     $editor =& JFactory::getUser();
       
	   $editDataOf = JRequest::getVar('editDataOf', 0 , 'GET');
	   
	   if($editDataOf == '')
	       $editDataOf = $editor->id;
	   
		
		$editInfo = new stdClass();
		 
		 // setting object with actual values
	     $editInfo->editDataOf = $editDataOf;  
	     $editInfo->editDataOfName = JFactory::getUser($editDataOf)->name; 
	     $editInfo->editorName = JFactory::getUser($editor->id)->name;    
	     $editInfo->profiletypeId = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($editDataOf);
	     $editInfo->editorId = $editor->id;
	     $editInfo->canEdit = XiPTLibraryCore::checkEditAccessRight($editor->id , $editDataOf );   
      
      return $editInfo;
  }
  
}