<?php
/**
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
	
	
	function validateProfiletypeId($profileTypeID)
	{
		if(empty($profileTypeID))
			return;
		
		$allProfileTypes = XiPTLibraryProfiletypes::getProfileTypesArray();
		
		if(empty($allProfileTypes))
			return false;

		foreach($allProfileTypes as $pType) {
			if($profileTypeID == $pType->id)
				return true;
		}
		
		return false;
	}
	
	//return ptype name from id
	function getProfileTypeNameFromID( $id = 0)
	{
		assert($id) || JError::raiseError('NOPTYERR',JText::_("NO SUCH PROFILETYPE EXIST"));
		
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
		
		if(empty($allProfileTypesId))
			return $ptypewithSelected;
		
		foreach($allProfileTypesId as $ptype){
			//if not selected any ptype then bydefault seletct default ptype
			if(empty($seletedProfileTypeID))
				$seletedProfileTypeID = XiPTLibraryProfiletypes::getDefaultPTypeId();
			if(empty($seletedProfileTypeID))	
				$seletedProfileTypeID = $ptype->id;
			if($ptype->id == $seletedProfileTypeID)
				$ptypewithSelected[$ptype->id] = 1;
			else
				$ptypewithSelected[$ptype->id] = 0;
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
	
	
		
	
	function getProfiletypeFieldsinEditMode(&$fields,$selectedProfiletypeID) 
	{
		if(empty($selectedProfiletypeID))
			return;
			
		$notSelectedFields = XiPTLibraryProfiletypes::getNotSelectedFieldForProfiletype($selectedProfiletypeID);
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
		$fields = array_values($fields);
	}
	
	
	//call fn to update fields during registration	
	function getProfiletypeFields(&$fields,$selectedProfiletypeID)
	{
		if(empty($selectedProfiletypeID))
			return;
			
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
		
		if(!XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($userAvatar,true))
			return;
		
		$pTypeAvatar 	= XiPTLibraryProfiletypes::getProfileTypeData($profiletypeID,'avatar');	
		$pTypeThumbAvatar =  XiPTLibraryProfiletypes::getThumbAvatarFromFull($pTypeAvatar);
		
		$extraSql 	=  $db->nameQuote('avatar' ) . '=' . $db->Quote( $pTypeAvatar );
		$extraSql 	.= ' , ' . $db->nameQuote('thumb' ) . '=' . $db->Quote( $pTypeThumbAvatar );
		
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
	function updatePrivacyforCommunityUser($userid,$profiletypeId) 
	{
		
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
	
	
	
	function setCustomField($userId, $value,$what=TEMPLATE_FIELD_NAME) 
	{
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
	
	
	// TODO :( DONE ) give an option to optionally check for default.jpg
	function isDefaultAvatarOfProfileType($path,$isDefaultCheckRequired = false)
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
			if($isDefaultCheckRequired && ( Jstring::stristr('components/com_community/assets/default.jpg' ,$path)
				|| Jstring::stristr('components/com_community/assets/default_thumb.jpg' ,$path)))
				return true;
		}
		
		return false;
	}
	
	
	
		
	
	function getUserProfiletypeFromUserID($userid) 
	{
		//here raise error not required b'coz there some situation can occur 
		//where we userid does not exist then don't raise error
		//just assert then some wrong happen
		assert($userid) || JError::raiseWarning('NOUSERWAR',JText::_("NO USER ID TO"));
		
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
			$pID = XiPTLibraryProfiletypes::getDefaultPTypeId();
			return $pID;
		}
		
		return $myProfiletype;
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
		
	
	
	
	
	//template related function
	
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
	
	
	
	//application related function
	
	function getAllowedApps(&$applications,$appname)
	{
		if(!empty($applications)) {
			$i = 0;
			$user = & CFactory::getUser();
			if($user->_userid) {
				$userProfiletypeId = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($user->_userid);
				foreach($applications as $app) {
					if(!XiPTLibraryProfiletypes::getcheckaccess($app->$appname,$userProfiletypeId))
						unset($applications[$i]);
					$i++;
				}
				$applications = array_values($applications);
			}
		}
	}

	function getcheckaccess($appname,$userProfiletypeId)
	{
			$appsModel = CFactory::getModel('apps');
			$checkaccess = XiPTLibraryProfiletypes::checkAccessofApplication(
			$appsModel->getPluginId( $appname ),$userProfiletypeId);
			return $checkaccess;
	}
	
	
	function checkAccessofApplication($applicationId,$userProfiletypeId)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT ' . $db->nameQuote( 'id' ) . ' ' 
				. 'FROM ' . $db->nameQuote( '#__xipt_applications' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'applicationid' ) . '=' . $db->Quote( $applicationId ) . ' '
				. 'AND ' . $db->nameQuote( 'profiletype' ) . '=' . $db->Quote( $userProfiletypeId );

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
	
	
}