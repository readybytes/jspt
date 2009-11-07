<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

class XiPTLibraryProfiletypes
{
	
	function getDefaultPTypeId()
	{
		$params = JComponentHelper::getParams('com_xipt');
		$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
		$pID = $defaultProfiletypeID;
		return $pID;
	}
	
	//return ptype name from id
	function getProfileTypeNameFromID( $id = 0)
	{
		
		assert($id);
		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('name').' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id) ;
		$db->setQuery( $query );
		$val = $db->loadResult();
		return $val;
	}

	//return array of all published profile type id
	function getProfileTypesArray()
	{
		$db			=& JFactory::getDBO();
		$query		= ' SELECT *'
					. ' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('published').'='.$db->Quote('1')
					. ' ORDER BY '.$db->nameQuote('ordering');
		$db->setQuery( $query );
		
		$profiletypes = $db->loadObjectList();
		return $profiletypes;
	}
	
	
	//return profiletypeid array with selected ptype as true
	function getSelectedProfileTypesArray($seletedProfileTypeID = '')
	{
		$allProfileTypesId = XiPTLibraryProfiletypes::getProfileTypesArray();
		
		$ptypewithSelected = array();
		
		if(!empty($allProfileTypesId)){
			foreach($allProfileTypesId as $ptype){
				if(empty($seletedProfileTypeID))
					$seletedProfileTypeID = $ptype->id;
				if($ptype->id == $seletedProfileTypeID)
					$ptypewithSelected[$ptype->id] = 1;
				else
					$ptypewithSelected[$ptype->id] = 0;
			}
		}
		
		return $ptypewithSelected;
	}
	
	
	function saveFieldForUser($userId,$value,$what)
	{
		$db		=& JFactory::getDBO();
		switch($what)
		{
			case PROFILETYPE_FIELD_NAME:
				$extraSql = ' SET '.$db->nameQuote(PROFILETYPE_FIELD_IN_USER_TABLE)
				 . '=' . $db->Quote($value);
				break;
			
			case TEMPLATE_FIELD_NAME:
				$extraSql = ' SET '.$db->nameQuote(TEMPLATE_FIELD_IN_USER_TABLE) 
				. '=' . $db->Quote($value);
				break;
			default:
				return;
		}
			
			$strSQL	= 'UPDATE ' . $db->nameQuote('#__xipt_users')
					 	. $extraSql
						. ' WHERE ' . $db->nameQuote('userid') . '=' . $db->Quote($userId);
			$db->setQuery( $strSQL );
			$db->query();
	}
	
	function getFieldInfofromFieldId($fieldid)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT * FROM '
				. $db->nameQuote( '#__community_fields' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $fieldid );
		
		$db->setQuery( $query );
		
		$result	= $db->loadObject();
		
		return $result; 
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
	

	//TODO : When user don't change his ptype then don't change his other settings.
	//function will call when value will be updated in community_fields_values table
	function updateProfileFieldsValueEvent($userId,$isNew,$fieldID,$value)
	{
		$fieldInfo = XiPTLibraryProfiletypes::getFieldInfofromFieldId($fieldID);
		if($fieldInfo->type == PROFILETYPE_FIELD_NAME)
			XiPTLibraryProfiletypes::setProfileDataForUserID($userId,$value,'ALL');	
		else if($fieldInfo->type == TEMPLATE_FIELD_NAME)
			XiPTLibraryProfiletypes::saveFieldForUser($userId,$value,TEMPLATE_FIELD_NAME);
		
		return;
	}
	
	
	function getProfiletypeFieldsinEditMode(&$fields,$selectedProfiletypeID) 
	{
		if(!empty($selectedProfiletypeID)) {
			$notSelectedFields = XiPTLibraryProfiletypes::getNotSelectedFieldForProfiletype($selectedProfiletypeID);
			//unset($ar[2]);
			$requiredUnset = false;
			$i = 0;
			foreach( $fields as $field ) {
			if($field['type'] == PROFILETYPE_FIELD_NAME 
				|| $field['type'] == TEMPLATE_FIELD_NAME)  {
					$fields[$i]['searchLink'] = CRoute::_('index.php?option=com_community&view=search&task=field&'.$field['fieldcode'].'='. urlencode( $field['value'] ) );
				}
				
				if($field['type'] == 'group') {
					$requiredUnset = false;
					if(in_array($field['id'],$notSelectedFields)) {
						unset($fields[$i]);
						//assuming all fields are member of this group
						//and unset all field till next group
						$requiredUnset = true;
					}
				}
				else if($requiredUnset || in_array($field['id'],$notSelectedFields))
					unset($fields[$i]);
					
				$i++;
			}
		}
		$fields = array_values($fields);
	}
	
	
	
	function getFieldsInEditMode($userid,&$fields)
	{
		$pTypeID = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($userid);
		assert($pTypeID);
		XiPTLibraryProfiletypes::getProfiletypeFieldsinEditMode($fields,$pTypeID);
	}
	
	
	//show fields according to profiletype during registration
	function getFieldsDuringRegistration(&$fields) {
		//get profieltype value from session 
		$mySess = & JFactory::getSession();
		if($mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
			&& (($selectedProfiletypeID = $mySess->get('SELECTED_PROFILETYPE_ID',0, 'XIPT'))
				 != 0)) {
						XiPTLibraryProfiletypes::getProfiletypeFields($fields,$selectedProfiletypeID);
		}
	}
	
	
	function getProfiletypeFields(&$fields,$selectedProfiletypeID) {
		if(!empty($selectedProfiletypeID)) {
			$notSelectedFields = XiPTLibraryProfiletypes::getNotSelectedFieldForProfiletype($selectedProfiletypeID);
			//unset($ar[2]);
			foreach( $fields as $group ) {
				if(in_array($group->id,$notSelectedFields)) {
					unset($fields[$group->name]);
					continue;
				}
				$i = 0;
				foreach($group->fields as $field ) {
					if(in_array($field->id,$notSelectedFields)) 
						unset($group->fields[$i]);
						
					$i++;	
				}
				$group->fields = array_values($group->fields);
			}
		}
	}
	
	
	//assuming that by default all fields are available to all profiletype
	//if any info is stored in table means that field is not available to that profiletype
	//we store info in opposite form
	function getNotSelectedFieldForProfiletype($profiletypeId)
	{
		//XIPT_NONE means none , means not visible to any body
		
		$notselected = array();
		//Load all fields for profiletype
		$db			=& JFactory::getDBO();
		$query		= 'SELECT * FROM ' . $db->nameQuote( '#__xipt_profilefields' ) 
					. ' WHERE '.$db->nameQuote('pid').'='.$db->Quote($profiletypeId);
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
		if(!empty($results)) {
		//create array of result profile type
			foreach($results as $result) {
		      $notselected[] = $result->fid;
		 	 }
		}
 		return $notselected;
	}

	
	
	function saveUser($userid,$profiletype,$template) 
	{
		
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
		
		if(XiPTLibraryProfiletypes::isAdmin($userid)==false) {
				
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
	
	//get required user info from community_users table
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
	
	
	function updateAvatarinCommunityUser($userid,$profiletypeID) 
	{
		
		$db			=& JFactory::getDBO();
		
		$userAvatar = XiPTLibraryProfiletypes::getUserDataFromCommunity($userid,'avatar');
		
		if(!XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($userAvatar))
			return;
		
		$pTypeAvatar 	= XiPTLibraryProfiletypes::getProfileTypeData($profiletypeID,'avatar');	
		$ptype_thumb_avatar =  XiPTLibraryProfiletypes::getThumbAvatarFromFull($pTypeAvatar);
		
		$extraSql 	=  $db->nameQuote('avatar' ) . '=' . $db->Quote( $pTypeAvatar );
		$extraSql 	.= ' , ' . $db->nameQuote('thumb' ) . '=' . $db->Quote( $ptype_thumb_avatar );
		
		// perform the operation
		$query	= ' UPDATE ' . $db->nameQuote( '#__community_users' )
	    		. ' SET ' 
				. $extraSql
	    		. ' WHERE ' . $db->nameQuote( 'userid' ) . '=' . $db->Quote( $userid );
	    
		$db->setQuery($query);
	    $db->query();
		if($db->getErrorNum())
			JError::raiseError( 500, $db->stderr());
		
	}
	
	
	function getPTPrivacyValue($privacy) 
	{
			$value=PRIVACY_PUBLIC;
			switch($privacy)
			{
				case "friends":
					$value = PRIVACY_FRIENDS;
					break;
				case "members":
					$value = PRIVACY_MEMBERS;
					break;
				case "public":
					$value = PRIVACY_PUBLIC;
					break;
				default:
					assert(0);
			}
		return $value;
	}
	
	
	/*This function set privacy for user as per his profiletype*/
	function updatePrivacyforCommunityUser($userid,$profiletypeId) {
		
		$privacy 	= XiPTLibraryProfiletypes::getProfileTypeData($profiletypeId,'privacy');
		$myprivacy	= XiPTLibraryProfiletypes::getPTPrivacyValue($privacy);
		
		// get params
		$db 	=& JFactory::getDBO();
 		$sql 	= " SELECT ".$db->nameQuote('params')." FROM #__community_users"
 				. " WHERE ".$db->nameQuote('userid')."=".$db->Quote($userid);
		$db->setQuery($sql);
		$myresult = $db->loadResult();
		
		// if error occurs 
 		if($db->getErrorNum())
 			JError::raiseError( 500, $db->stderr());
	
		$myparams = new JParameter($myresult);		
		$myparams->set('privacyProfileView',$myprivacy);
		
		//SET params
 		$sql = "UPDATE #__community_users"
 			." SET ".$db->nameQuote('params')."=".$db->Quote($myparams->toString())
 			." WHERE ".$db->nameQuote('userid')."=".$db->Quote($userid);
 		
 		$db->setQuery($sql);
 		$db->query($sql);

 		// if error occurs 
 		if($db->getErrorNum())
 			JError::raiseError( 500, $db->stderr());
	
	}
	
	
	
	function setCustomField($userId, $value,$what=TEMPLATE_FIELD_NAME) {
		// find the profiletype or template fields (all)
		$db		=& JFactory::getDBO();
		$query 	= 'SELECT * FROM `#__community_fields`'
				 .' WHERE '.$db->nameQuote('type').'='.$db->Quote($what);
		$db->setQuery( $query );
		$results = $db->loadObjectList();		
				
		//$value = XiPTLibraryProfiletypes::getProfileTypeData($value,'name');
		// change the type
		foreach($results as $res)
		{	
			$id	= $res->id;
			$strSQL	= 'UPDATE ' . $db->nameQuote('#__community_fields_values') 
						. ' SET '. $db->nameQuote('value') . '=' . $db->Quote($value)
						. ' WHERE ' . $db->nameQuote('user_id') . '=' . $db->Quote($userId)
						. ' AND ' . $db->nameQuote('field_id') . '=' . $db->Quote($id);
			$db->setQuery( $strSQL );
			//print_r($strSQL);
			$db->query();
		}
		return;
	}
	
	
	// TODO : give an option to optionally check for default.jpg
	function isDefaultAvatarOfProfileType($path)
	{
		$searchFor 		= 'avatar';
		
		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote($searchFor) 
					.' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) ;
		$db->setQuery( $query );
		$all = $db->loadObjectList();
		
		if($all)
		foreach ($all as $one)
		{
			if(Jstring::stristr($one->avatar ,$path))
				return true;
			if(Jstring::stristr($path, XiPTLibraryProfiletypes::getThumbAvatarFromFull($one->avatar)))
				return true;
			if(Jstring::stristr('components/com_community/assets/default.jpg' ,$path)
				|| Jstring::stristr('components/com_community/assets/default_thumb.jpg' ,$path))
				return true;
		}
		
		return false;
	}
	
	
	
	// ALL means you are from register
	function setProfileDataForUserID($userid, $ptype, $what='ALL') {
		//during registration
		if($what == 'ALL') {
			//1.set profiletype and template for user in #__xipt_users table
			$template = XiPTLibraryProfiletypes::getProfileTypeData($ptype,'template');
			XiPTLibraryProfiletypes::saveUser($userid,$ptype,$template);
			
			//2.set usertype acc to profiletype in #__user table
			XiPTLibraryProfiletypes::saveUserTypeinUser($userid,$ptype);
			
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

			//TODO : well defined comment should be here.			
			$user	=& CFactory::getUser($userid);
			$user	= array();
			$user	=& CFactory::getUser($userid);
		}
	}
	
	
	function getUserProfiletypeFromUserID($userid) {
		assert($userid);
		$db		=& JFactory::getDBO();
		$getMe	= PROFILETYPE_FIELD_IN_USER_TABLE;
		$query	= 'SELECT ' . $db->nameQuote($getMe) . ' FROM '
				. $db->nameQuote( '#__xipt_users') . ' WHERE '
				. $db->nameQuote( 'userid') . '=' . $db->Quote( $userid );
		
		$db->setQuery( $query );
		
		$myProfiletype	= $db->loadResult();
		if($db->getErrorNum()) {
				JError::raiseError( 500, $db->stderr());
		}	

		// return the default profiletype if it is 0
		if($myProfiletype==0) {
			$params = JComponentHelper::getParams('com_xipt');
			$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
			return $defaultProfiletypeID;
		}
		
		return $myProfiletype;
	}
	
	
	//application related function
	
	function getAllowedApps(&$applications,$appname)
	{
		if(!empty($applications)) {
			$i = 0;
			$user = & CFactory::getUser(); 
			$user_profiletype = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($user->_userid);
			foreach($applications as $app) {
				if(!XiPTLibraryProfiletypes::getcheckaccess($app->$appname,$user_profiletype))
					unset($applications[$i]);
				$i++;
			}
			$applications = array_values($applications);
		}
	}

	function getcheckaccess($appname,$user_profiletype)
	{
			$appsModel = CFactory::getModel('apps');
			$checkaccess = XiPTLibraryProfiletypes::checkAccessofApplication(
			$appsModel->getPluginId( $appname ),$user_profiletype);
			return $checkaccess;
	}
	
	
	function checkAccessofApplication($applicationId,$user_profiletype)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT ' . $db->nameQuote( 'id' ) . ' ' 
				. 'FROM ' . $db->nameQuote( '#__xipt_applications' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'applicationid' ) . '=' . $db->Quote( $applicationId ) . ' '
				. 'AND ' . $db->nameQuote( 'profiletype' ) . '=' . $db->Quote( $user_profiletype );

		$db->setQuery( $query );

		$result = $db->loadResult();
		
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
		
		if(empty($result))
			return 1;
		else
			return 0;
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function canEditMe($myId, $calleId)
	{
		return XiPTLibraryProfiletypes::checkEditAccessRight($myId, $calleId);
	}
	
	 
	
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
				return XiPTLibraryProfiletypes::isAdmin($refID) ? false : true;
				
		}
		return false;	
	}
	
	function checkEditAccessRight($myId, $calleId)
	{
		// Always I can edit my own profile
		if($myId ==  $calleId)
			return true;
			
		// are u superadmin or admin, 
		if(XiPTLibraryProfiletypes::isAdmin($myId, $calleId))
			return true;
    
		return false;
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
	     $editInfo->canEdit = XiPTLibraryProfiletypes::checkEditAccessRight($editor->id , $editDataOf );   
      
      return $editInfo;
  }
  
	
	
	
	
	
	
	
	
	function getChildProfileTypes($id = 0)
	{
		if($id !=0 )
			return;
		$db			=& JFactory::getDBO();
		$query		= ' SELECT '.$db->nameQuote('id').','.$db->nameQuote('name').','.$db->nameQuote('tip')
					. ' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('published').'='.$db->Quote('1')
					. ' ORDER BY '.$db->nameQuote('ordering');
		$db->setQuery( $query );
		
		//print_r("query for getChildProfileTypes -  ".$query);
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function getProfiletypeFieldHTML( $value)
	{	
		//print_r("Profile Type for : ".$value);
		$required			='1';
		$html				= '';
		$selectedElement	= 0;
		$class				= ($required == 1) ? ' required' : '';
		$elementSelected	= 0;
		$elementCnt	        = 0;
		$options			= XiPTLibraryProfiletypes::getChildProfileTypes($value);
		
		$config = CFactory::getConfig();
		
		$data = array();
		$data			= XiPTLibraryProfiletypes::getHiddenParameterForProfiletype();
		
		if($data['hidden'])
		{
			$link = JRoute::_('index.php?option=com_acctexp&task=subscribe',false);
			switch($config->get('aecmessage'))
			{
				case 'pl' : 
						$message = 'plan as <strong>'.$data['plan'].'</strong>';
						break;
				case 'pt' : 
						$message = 'profiletype as <strong>'.XiPTLibraryProfiletypes::getProfileTypeNameFrom($data['profiletype']).'</strong>';
						break;
				case 'b' :
				default :
						$message = 'plan as <strong>'.$data['plan'].'</strong> ( '.XiPTLibraryProfiletypes::getProfileTypeNameFrom($data['profiletype']).' )';
						break;
			}
			return JText::sprintf('CC SELECTED PLAN',$message,$link);
		}
			
		for( $i = 0; $i < count($options ); $i++ )
		{
		    $option		= $options[ $i ]->name;
			$id			= $options[ $i ]->id;
			
			$selected	= ( $id == $selectedChildType ) ? ' checked="true"' : '';
			
			if( empty( $selected ) )
			{
				$elementSelected++;
			}			
			$elementCnt++;				
		}
		//print_r($selectedChildType);
		
		$cnt = 0;
		for( $i = 0; $i < count( $options ); $i++ )
		{
		    $option		= $options[ $i ]->name;
			$id			= $options[ $i ]->id;
			$tip		= $options[ $i ]->tip;
		    
		    if(($required == 1) && ($elementSelected == $elementCnt) && ($cnt == 0)){
		       $selected	= ' checked="checked"'; //default checked for the 1st item.
		    } else {
		       $selected	= ( $id == $selectedChildType ) ? ' checked="checked"' : '';
		    }
		    $cnt++;		    		    
			
			$html 	.= '<label class="label" style="
						font-size: 14px; color: #000000;
						line-height: 16px;height: 16px;
						font-weight: bold;padding-top:10px;">';
			$html	.= '<input type="radio" id="profiletypes" name="profiletypes" value="' . $id . '"' . $selected . '  style="margin: 0 5px 0 0;" />';
			$html	.= $option . '</label>
			<span style="padding-right:250px;
			 font-size: 10px; color: #000000;
			line-height: 12px;height: 12px;">' . $tip .'</span>';
		}
						
		
		$html   .= '<span id="errprofiletypemsg" style="display: none;">&nbsp;</span>';
		
		return $html;
	}
	
	function getEditProfiletypeFieldHTML($value)
	{	
		//print_r("Profile Type for : ".$value);
		$required			='1';
		$html				= '';
		$selectedElement	= 0;
		$class				= ($required == 1) ? ' required' : '';
		$elementSelected	= 0;
		$elementCnt	        = 0;
		$options			= XiPTLibraryProfiletypes::getChildProfileTypes(0);
		
		$config = CFactory::getConfig();
		
		$data = array();
		$data			= XiPTLibraryProfiletypes::getHiddenParameterForProfiletype();
		
		if($data['hidden'])
		{
			$message = '';
			$link = JRoute::_('index.php?option=com_acctexp&task=subscribe',false);
			switch($config->get('aecmessage'))
			{
				case 'pl' : 
						$message = 'plan as <strong>'.$data['plan'].'</strong>';
						break;
				case 'pt' : 
						$message = 'profiletype as <strong>'.XiPTLibraryProfiletypes::getProfileTypeNameFrom($data['profiletype']).'</strong>';
						break;
				case 'b' :
				default :
						$message = 'plan as <strong>'.$data['plan'].'</strong> ( '.XiPTLibraryProfiletypes::getProfileTypeNameFrom($data['profiletype']).' )';
						break;
			}
			return JText::sprintf('CC SELECTED PLAN',$message,$link);
		}
	
		$cnt = 0;
		$html	.= '<select id="profiletypes" name="profiletypes" class="hasTip select'.$class.'" title="' . "Select Account Type" . '::' . "Please Select your account type" . '">';
		for( $i = 0; $i < count( $options ); $i++ )
		{
		    $option		= $options[ $i ]->name;
			$id			= $options[ $i ]->id;
		    
		    $selected	= ( JString::trim($id) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $id . '"' . $selected . '>' . $option . '</option>';
		}
		$html	.= '</select>';	
		$html   .= '<span id="errprofiletypemsg" style="display: none;">&nbsp;</span>';
		
		return $html;
	}
	
	function getHiddenParameterForProfiletype()
	{
		if(!XiPTLibraryProfiletypes::check_aec_existance())
			return;
		
		$config = CFactory::getConfig();
		$param = array();
		$param['hidden'] = false;
		$param['profiletype'] = $config->get('profiletypes');
		$param['plan'] = '';
		$param['planid'] = 0;
		$mySess 	=& JFactory::getSession();
		if(isset($_REQUEST))
		{
			if(JRequest::getVar( 'usage', '0', 'REQUEST') || $mySess->has('JSPT_REG_PLANID','JSPT'))
			{
				$planid = JRequest::getVar( 'usage', '0', 'REQUEST') ? JRequest::getVar( 'usage', '0', 'REQUEST') : $mySess->get('JSPT_REG_PLANID','','JSPT');
				$param['planid'] = $planid;
				$param['plan'] = XiPTLibraryProfiletypes::getPlanNameFromPlanId($planid);
				$param['profiletype'] = XiPTLibraryProfiletypes::getAecPlanParameterFromId($planid);
				$param['hidden'] = true;
			}
			else
				$param['hidden'] = false;
		}
			
		return $param;
	}
	
	function getPlanNameFromPlanId($planid)
	{
		assert($planid);
		//check Existance of plan table
		if(!XiPTLibraryProfiletypes::checkExistanceofTable('acctexp_plans'))
			return '';
		
		//check existance of plan
		if(!XiPTLibraryProfiletypes::checkExistanceOfPlan($planid))
			return '';
			
		$db = &JFactory::getDBO();
		$query = 'SELECT '.$db->nameQuote('name')
			. ' FROM '.$db->nameQuote('#__acctexp_plans')
			. ' WHERE '.$db->nameQuote('id').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		$result = $db->loadResult();

		return $result;
	}
	
	function getAecPlanParameterFromId($planid)
	{
		return XiPTLibraryProfiletypes::getProfiletypebyPlanId($planid);
	}
	
	function getProfiletypebyPlanId( $planid ) {
		
		$config = CFactory::getConfig();
		$defaultptype =  $config->get('profiletypes');
		if(empty($defaultptype))
			$defaultptype = 0;
		
		//get MI from planid;
		
		$micro_integrations = XiPTLibraryProfiletypes::getMIfromPlanid($planid);
			
		if(!XiPTLibraryProfiletypes::checkExistanceofTable('community_jspt_aec'))
			return $defaultptype;
		
		//check existance of plan
		if(!XiPTLibraryProfiletypes::checkExistanceOfPlan($planid))
			return $defaultptype;
		
		
		if(!$micro_integrations)
			return $defaultptype;
		
		// if ANY jspt mi IS  attached to this plan, then return the 
		// proper profiletype.
		$db = &JFactory::getDBO();
		foreach($micro_integrations as $mi)
		{
			if(!XiPTLibraryProfiletypes::checkExistanceOfMI($mi))
				continue;
				
			$query = 'SELECT '.$db->nameQuote('profiletype')
				. ' FROM '.$db->nameQuote('#__xipt_jspt_aec')
				. ' WHERE '.$db->nameQuote('planid').'=' .$db->Quote($mi);
		
			$db->setQuery( $query );
			$result = $db->loadResult();

			if($result)
				return $result;
		}
				
		return $defaultptype;
	}
	
	
	function getMIfromPlanid($planid)
	{
		if(!XiPTLibraryProfiletypes::checkExistanceofTable('acctexp_plans'))
	 		return false;

		$db = &JFactory::getDBO();
		$query = 'SELECT '.$db->nameQuote('micro_integrations')
			. ' FROM '.$db->nameQuote('#__acctexp_plans')
			. ' WHERE '.$db->nameQuote('id').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		$result = $db->loadResult();

				
		if(!$result)
			return false;

		$micro_integration = unserialize(base64_decode($result));
		return $micro_integration;	
	}
	
	
	function checkExistanceOfPlan( $planid )
	 {
	 	if(!XiPTLibraryProfiletypes::checkExistanceofTable('acctexp_plans'))
	 		return false;

		$db = &JFactory::getDBO();

		$query = 'SELECT '.$db->nameQuote('id')
			. ' FROM '.$db->nameQuote('#__acctexp_plans')
			. ' WHERE '.$db->nameQuote('id').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		$result = $db->loadResult();
		
		if(empty($result))
			return 0;
		else
			return 1;
	}
	
function checkExistanceOfMI( $mi )
	 {
	 	if(!XiPTLibraryProfiletypes::checkExistanceofTable('acctexp_microintegrations'))
	 		return false;
		$db = &JFactory::getDBO();

		$query = 'SELECT '.$db->nameQuote('id')
			. ' FROM '.$db->nameQuote('#__acctexp_microintegrations')
			. ' WHERE '.$db->nameQuote('id').'=' .$db->Quote($mi);
		
		$db->setQuery( $query );
		$result = $db->loadResult();
		if(empty($result))
			return 0;
		else
			return 1;
	}
	
	function checkExistanceofTable($tname)
	{
		$database = &JFactory::getDBO();

		global $mainframe;

		$tables	= array();
		$tables	= $database->getTableList();

		return in_array( $mainframe->getCfg( 'dbprefix' ) . $tname, $tables );
	}
	
	function check_aec_existance()
	{
		$aec_front = JPATH_ROOT . DS . 'components' . DS . 'com_acctexp';
		return JFolder::exists($aec_front);
	}
	
	
	function getTemplatesList()
	{
		jimport( 'joomla.filesystem.folder' );
		jimport('joomla.filesystem.file');
		
		$path	= JPATH_ROOT. DS . 'components' . DS . 'com_community' . DS . 'templates';
		
		if( $handle = @opendir($path) )
		{
			while( false !== ( $file = readdir( $handle ) ) )
			{
				// Do not get '.' or '..' or '.svn' since we only want folders.
				if( $file != '.' && $file != '..' && $file != '.svn' )
					$templates[]	= $file;
			}
		}
		return $templates;
	}
	
	function getTemplateOfuser($id)
	{
		if(!$id || $id<1 )
		{
			return false;
		}
		$db		=& JFactory::getDBO();
		$getMe	= TEMPLATE_FIELD_IN_USER_TABLE;
		$query	= 'SELECT ' . $db->nameQuote($getMe) . ' FROM '
				. $db->nameQuote( '#__xipt_users') . ' WHERE '
				. $db->nameQuote( 'userid') . '=' . $db->Quote( $id );
		
		$db->setQuery( $query );
		//print_r($query);
		$myTemplate	= $db->loadResult();
		if($db->getErrorNum()) {
				JError::raiseError( 500, $db->stderr());
				return false;
		}
		$allTemplates = XiPTLibraryProfiletypes::getTemplatesList();
		// not a valid template
		if(in_array($myTemplate,$allTemplates)==false)
		{
			// try to get user's profile type template
			$pID = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($id);
			$myTemplate = XiPTLibraryProfiletypes::getProfileTypeData($pID,'template');
			if(in_array($myTemplate,$allTemplates)==false)
			{
				$myTemplate=false;
			}
		}
		return $myTemplate;		
	}
	function getTemplateSelectionHTML($value)
	{
		$config	=& CFactory::getConfig();
		if($config->get('jspt_allow_templatechange')==false) 
			return '';

			
		$required			='1';
		$html				= '';
		$selectedElement	= 0;
		$class				= ($required == 1) ? ' required' : '';
		$elementSelected	= 0;
		$elementCnt	        = 0;
		$options			= XiPTLibraryProfiletypes::getTemplatesList();
	
		$cnt = 0;
		$html	.= '<select id="myTemplate" name="myTemplate" class="hasTip select'.$class.'" title="' . "Select Template" . '::' . "Please Select your template" . '">';
		foreach ($options as $option)
		{
		    $selected	= ( JString::trim($option) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $option . '"' . $selected . '>' . ucfirst($option) . '</option>';
		}
		$html	.= '</select>';	
		$html   .= '<span id="errmyTemplatemsg" style="display: none;">&nbsp;</span>';
		
		return $html;
	}
	
	function getThumbAvatarFromFull($avatar)
	{
		//print_r("avatar type : ".$type);
		jimport('joomla.filesystem.file');
		$ext = JFile::getExt($avatar);
		$thumb = JFile::stripExt($avatar).'_thumb.'.$ext;
		$avatar = $thumb;				
		//print_r($thumb);
		return $thumb;
	}
	
	
	
		
	function isProfileTypeDataResetRequired($id, $check, $what='ALL')
	{
		$config	=& CFactory::getConfig();
		if($what == 'ALL')
			return true;
			
		if($what != 'profiletype')
			return false;
				
		switch($check)
		{
			case 'usertype' 	:
					//return $config->get('jspt_reset_usertype');
			case 'template' 	:
					//return $config->get('jspt_reset_template');
			case 'privacy'		:
					//return $config->get('jspt_reset_privacy');
					return true;
					
			case 'avatar' 		:
				// IF user have custom avatar, then it MUST not be discarded
				$db			=& JFactory::getDBO();
				$tquery		= ' SELECT '. $db->nameQuote('avatar' ) 
							. ' FROM '	. $db->nameQuote( '#__community_users' )
							. ' WHERE ' . $db->nameQuote('userid').'='.$db->Quote($id);
				$db->setQuery($tquery);
				$oldAvatar	= $db->loadResult(); 
				$isDefault	= XiPTLibraryProfiletypes::isAvatarOfProfileType($oldAvatar);
				if(!$isDefault)
					return false;
				//return $config->get('jspt_reset_avatar');
				return true;
			default :
				assert(0);
		}
	}
	
	
	
	
	function getFieldArrayForProfiletypeId($pid='0')
	{
		$retVal	= array();
			
		//Load all profiletypes for the field
		if($pid == '')
		{
			$pid = '0';
		}
		$db			=& JFactory::getDBO();
		$query		= ' SELECT '.$db->nameQuote('fid').' FROM ' . $db->nameQuote( '#__xipt_profilefields' ) 
					. ' WHERE '.$db->nameQuote('pid').'='.$db->Quote($pid) 
					. ' OR '.$db->nameQuote('pid').'='.$db->Quote('0');
		$db->setQuery( $query );
		//print_r($query);
		$results = $db->loadObjectList();
		//print_r($results);
		
		if($results)
			foreach ($results as $result)
			{
				//print_r($result);
				$retVal[]=$result->fid;
			}
		return $retVal;
	}
	
function getProfileTypeData($id,$what='name')
{
	if($id =='')
		$id='0';
	
	$searchFor 		= 'name';
	$defaultValue	= 'NONE';
	
	switch($what)
	{
		case 'name' :
				$searchFor 		= 'name';
				$defaultValue	= 'ALL';
				break;
					
		case 'privacy' :
				$searchFor 		= 'privacy';
				$defaultValue	= 'friends';
				break;
					
		case 'template' :
				$searchFor 		= 'template';
				$defaultValue	= 'dafault';
				break;
		case 'jusertype' :
				$searchFor 		= 'jusertype';
				$defaultValue	= 'Registered';
				break;
		case  'avatar':
				$searchFor 		= 'avatar';
				$defaultValue	= 'components/com_community/assets/default.jpg';
				break;
		case  'approve':
				$searchFor 		= 'approve';
				$defaultValue	= true;
				break;
		case	'allowt':
				$searchFor 		= 'allowt';
				$defaultValue	= false;
				break;
		case	'group':
				$searchFor 		= 'group';
				$defaultValue	= false;
				break;
		default	:
				assert(0);
	}

	if($id==0)
		return $defaultValue;
		
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '. $db->nameQuote($searchFor) .' FROM ' 
				. $db->nameQuote( '#__xipt_profiletypes' ) 
				. ' WHERE '.$db->nameQuote('id').'='. $db->Quote($id);
	
	$db->setQuery( $query );
	$val = $db->loadResult();
	return $val;
}	

	
	
function assignUserToGroup($userId,$profileTypeId)
{
	$juser = JFactory::getUser($userId);

	// if user is changing profiletype then remove it from other group
	$oldProfileTypeId = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($userId);
	$oldGroup = XiPTLibraryProfiletypes::getProfileTypeData($oldProfileTypeId,'group');
	if($oldProfileTypeId != $profileTypeId)
		XiPTLibraryProfiletypes::remove_user_from_group($juser->id,$oldGroup);
	
	// add to new group
	$group = XiPTLibraryProfiletypes::getProfileTypeData($profileTypeId,'group');
	XiPTLibraryProfiletypes::add_user_to_group($juser->id,$group);
}


function add_user_to_group( $userId , $groupId)
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
    
function remove_user_from_group($userId , $groupId)
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

	
	
	function checkIfEmailAllowed($testEmail)
	{
		$config	=& CFactory::getConfig();
		
		$jspt_restrict_reg_check = $config->get('jspt_restrict_reg_check');
		if($jspt_restrict_reg_check == false)
			return true;
			
		$jspt_allowed_email = $config->get('jspt_allowed_email');
		$jspt_prevent_email = $config->get('jspt_prevent_email');
		
		// is the email blocked
		$invalidemails		= explode(';',$jspt_prevent_email);
		$valid	= false;
		if($invalidemails!='' && $jspt_prevent_email !='')
		{						
			foreach($invalidemails as $invalidemail)
			{
				$email	= preg_quote(trim($invalidemail), '#');
				$email	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $email);
				$regex	= "#^(?:$email)$#i";
			
				if(preg_match($regex, $testEmail))
					return false;
			}
		}

		// if allowed email
		$validemails		= explode(';',$jspt_allowed_email);
		if($validemails!='' && $jspt_allowed_email != '')
		{						
			foreach($validemails as $validemail)
			{
				$email	= preg_quote(trim($validemail), '#');
				$email	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $email);
				$regex	= "#^(?:$email)$#i";
			
				if(preg_match($regex, $testEmail))
					return true;
			}
			return false;
		}
		return true;
		
	}
	
	function checkIfUsernameAllowed($testUsername)
	{
		//jspt_prevent_username
		$config	=& CFactory::getConfig();
		
		$jspt_restrict_reg_check = $config->get('jspt_restrict_reg_check');
		if($jspt_restrict_reg_check == false)
			return true;
			
		$jspt_prevent_username = $config->get('jspt_prevent_username');
		
		// is the email blocked
		$invalidUsernames		= explode(';',$jspt_prevent_username);
		$valid	= false;
		if($invalidUsernames!='')		
			foreach($invalidUsernames as $invalidUsername)
			{
				$username	= preg_quote(trim($invalidUsername), '#');
				$username	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $username);
				$regex	= "#^(?:$username)$#i";
			
				if(preg_match($regex, $testUsername))
					return false;
			}
		return true;
	}
	
	
	//Function to display plan selection message manner in configuration
	function getAecMessageFieldHTML($selectedVal)
	{	
		$manner = array();
		$manner['b'] = 'Both , Plan and Profiletype';
		$manner['pl'] = 'Only Plan';
		$manner['pt'] = 'Only Profiletype';
		 
		$html				= '';
		$html	.= '<select id="aecmessage" name="aecmessage" class="hasTip select" title="' . "Select AEC Message Display Manner" . '::' . "Please select display manner" . '">';
		foreach( $manner as $key => $value )
		{
		    $selected	= ( JString::trim($key) == $selectedVal ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}
		$html	.= '</select>';			
		return $html;
	}
	/*================== ACL RELATED FUNCTIONS  ====================*/
	
	
}