<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

define('XIPT_NOT_DEFINED','XIPT_NOT_DEFINED');
define('XIPT_NONE','XIPT_NONE');

require_once (JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php');
require_once (JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');


class XiPTLibraryProfiletypes
{
	
	//return ptype name from id
	function getProfileTypeNameFromID( $id = 'XIPT_NOT_DEFINED' ) {
		
		if($id=='XIPT_NOT_DEFINED')
			return 'XIPT_NOT_DEFINED';
			
		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('name').' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id) ;
		$db->setQuery( $query );
		$val = $db->loadResult();
		return $val;
	}

	//return array of all published profile type id
	function getProfileTypesArray() {
		$db			=& JFactory::getDBO();
		$query		= ' SELECT '.$db->nameQuote('id')
					. ' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('published').'='.$db->Quote('1')
					. ' ORDER BY '.$db->nameQuote('ordering');
		$db->setQuery( $query );
		
		$profiletypesID = $db->loadObjectList();
		return $profiletypesID;
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
	
	
	//show fields according to profiletype during registration
	function getFieldsDuringRegistration(&$fields) {
		//get profieltype value from session 
		$mySess = & JFactory::getSession();
		if($mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
			&& (($selectedProfiletypeID = $mySess->get('SELECTED_PROFILETYPE_ID','XIPT_NOT_DEFINED', 'XIPT'))
				 != 'XIPT_NOT_DEFINED')) {
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
					if(in_array($field->id,$notSelectedFields)) {
						unset($group->fields[$i]);
						continue;
					}
					$i++;	
				}
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
					. ' WHERE '.$db->nameQuote('pid').'='.$db->Quote($profiletypeId)
					. ' OR '.$db->nameQuote('pid').'='.$db->Quote('XIPT_NONE');
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

	
	
	function saveUser($userid,$profiletype,$template) {
		
		$db		=& JFactory::getDBO();
		$query	= "SELECT COUNT(*) FROM ".$db->nameQuote('#__xipt_users')
				  . " WHERE ".$db->nameQuote('userid').'='.$db->nameQuote('$userid');
					
		$db->setQuery( $query );

		$isNew	= ($db->loadResult() <= 0) ? true : false;
		
		$extraSql = '';
		if(!empty($profiletype))
			$extraSql1 = $db->nameQuote('profiletype') . '=' . $db->Quote($profiletype);
			
		if(!empty($template))
			$extraSql2 .= $db->nameQuote('template') . '=' . $db->Quote($template);

		$query	= "INSERT INTO " . $db->nameQuote('#__xipt_users')
				. ' SET ' . $db->nameQuote('userid') . '=' . $db->Quote($userid) . ', '
				. $db->nameQuote('profiletype') . '=' . $db->Quote($profiletype)
				. ', ' . $db->nameQuote('template') . '=' . $db->Quote($template);

		if(!$isNew){
			$query	= 'UPDATE ' . $db->nameQuote('#__xipt_users') . ' SET '
					. $db->nameQuote('profiletype') . '=' . $db->Quote($profiletype)
					. ' WHERE ' . $db->nameQuote('userid') . '=' . $db->Quote($userId);
		}
			//echo $strSQL;
			$db->setQuery( $query );
			$db->query();

	}
	
	
	
	
	// ALL means you are from register
	function setProfileDataForUserID($id, $type, $what='ALL') 
	{
		// set profile type
		$db			=& JFactory::getDBO();
		$extraSql 	= '';
		$config	=& CFactory::getConfig();
			

		// change profiletype jspt_allow_typechange
		if($what == 'profiletype' || $what=='ALL')
		{
			
			// change profile type
			//$extraSql 	.=  $db->nameQuote('profiletype' ) . '=' . $db->Quote( $type ) . ' ';
			
			// change the joomla user type
			if(XiPTLibraryProfiletypes::isAdmin($id)==false 
				&& XiPTLibraryProfiletypes::isProfileTypeDataResetRequired($id,'usertype',$what)) 
			{
				$user 			= clone(JFactory::getUser($id));		
				$authorize		=& JFactory::getACL();
				
				$newUsertype = XiPTLibraryProfiletypes::getProfileTypeData($type,'jusertype');
				$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
				if ( !$user->save() )
				{
					JError::raiseWarning('', JText::_( $user->getError()));
					return false;
				}
			}
			
			// also change the user's type in profiletype field.
			XiPTLibraryProfiletypes::setUserProfileTypeCustomField($id,$type);
			
			// assign the default group  
			XiPTLibraryProfiletypes::assignUserToGroup($id,$type);
		}

		// Do we need to change avatar
		if($what == 'avatar'  || $what=='ALL' 
				|| XiPTLibraryProfiletypes::isProfileTypeDataResetRequired($id,'avatar',$what))
		{			
			$myavatar 	= XiPTLibraryProfiletypes::getProfileTypeData($type,'avatar');
			$thumb_avatar =  XiPTLibraryProfiletypes::getThumbAvatarFromFull($myavatar);
			if($extraSql !='')
				$extraSql 	.= ',';
				
			$extraSql 	.=  $db->nameQuote('avatar' ) . '=' . $db->Quote( $myavatar ) . ' ';
			$extraSql 	.= ',' . $db->nameQuote('thumb' ) . '=' . $db->Quote( $thumb_avatar ) . ' ';
		}
		
		// are we allowed to change, or we should reset ???
		if($what == 'template' || $what=='ALL' 
			|| XiPTLibraryProfiletypes::isProfileTypeDataResetRequired($id,'template',$what))
		{
			// do we need to set default template as per profile type
			if($what=='ALL' || XiPTLibraryProfiletypes::isProfileTypeDataResetRequired($id,'template')) 
				$template = XiPTLibraryProfiletypes::getProfileTypeData($type,'template');
			else
				$template = $type;
				
			//$extraSql 	.= $db->nameQuote('template' ) . '=' . $db->Quote( $template ) . ' ';
		}
		
		// do we need to reset privacy
		if($what == 'ALL' 
				|| XiPTLibraryProfiletypes::isProfileTypeDataResetRequired($id,'privacy',$what))
			XiPTLibraryProfiletypes::setPrivacyDataForUserID($id,$type);
		

		// it cannot be null, might be due to configuration
		if($extraSql=='')
		{
			return;
		}
		
		// perform the operation
		$query	= 'UPDATE ' . $db->nameQuote( '#__community_users' ) . ' '
	    		. 'SET ' 
				. $extraSql
	    		. 'WHERE ' . $db->nameQuote( 'userid' ) . '=' . $db->Quote( $id );
	    
		$db->setQuery( $query );
	    $db->query( $query );
		if($db->getErrorNum())
			JError::raiseError( 500, $db->stderr());
			
			
		XiPTLibraryProfiletypes::saveUser($id,$type,$template);
		// everything fine
	}
	
	
	function getUserProfiletypeFromUserID($userid) {
		assert($userid);
		$db		=& JFactory::getDBO();
		$getMe	= 'profiletype';
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
		$getMe	= 'template';
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
	
	function setUserProfileTypeCustomField($userId, $value)
	{
		// find the profiletype fields (all)
		$db		=& JFactory::getDBO();
		$query 	= 'SELECT * FROM `#__community_fields` WHERE '.$db->nameQuote('type').'='.$db->Quote('profiletypes');
		$db->setQuery( $query );
		$results = $db->loadObjectList();		
				
		$value = XiPTLibraryProfiletypes::getProfileTypeData($value,'name');
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
	
	/*This function set privacy for user as per his type*/
	function setPrivacyDataForUserID($id,$type)
	{
		
		$privacy 	= XiPTLibraryProfiletypes::getProfileTypeData($type,'privacy');
		$myprivacy	= XiPTLibraryProfiletypes::getPTPrivacyValue($privacy);
		
		// get params
		$db 	=& JFactory::getDBO();
 		$sql 	= " SELECT ".$db->nameQuote('params')." FROM #__community_users"
 				. " WHERE ".$db->nameQuote('userid')."=".$db->Quote($id);
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
 			." WHERE ".$db->nameQuote('userid')."=".$db->Quote($id);
 		
 		$db->setQuery($sql);
 		$db->query($sql);

 		// if error occurs 
 		if($db->getErrorNum())
 			JError::raiseError( 500, $db->stderr());
	
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
				$defaultValue	= 'NOT_DEFINED';
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

	function isAvatarOfProfileType($path)
	{
		$searchFor 		= 'avatar';
		
		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote($searchFor) .' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) ;
		$db->setQuery( $query );
		$all = $db->loadObjectList();
		
		if($all)
		foreach ($all as $one)
		{
			if(Jstring::stristr($one->avatar ,$path))
				return true;
			if(Jstring::stristr($path, XiPTLibraryProfiletypes::getThumbAvatarFromFull($one->avatar)))
				return true;
		}
		
		return false;
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

	function getcheckaccess($appname)
	{
			//print_r("id = ".$appname." fn = ".$fn);
			$user = & CFactory::getUser(); 
			$myapplicationModel = CFactory::getModel('myapplication');
			$appsModel = CFactory::getModel('apps');
			$checkaccess = $myapplicationModel->checkAccessofApplication(
								$appsModel->getPluginId( $appname ),$user->_userid);
			return $checkaccess;
	}
	//MEENAL HACK DONE
	
	function getRecaptcha()
	{
		$config	=& CFactory::getConfig();
		$recaptchaEnable = $config->get('jspt_captcha_during_reg');
		if(!$recaptchaEnable)
			return "";
		
		$publickey 		= $config->get('jspt_recaptcha_public_key');
		$privatekey  	= $config->get('jspt_recaptcha_private_key');
		$theme  		= $config->get('theme');
		
		require_once(JPATH_ROOT. DS . 'components' . DS . 'com_community' . DS . 'libraries'.DS.'recaptchalib.php');
		return recaptcha_get_html($publickey, $theme);
	}
	
	function verifyRecaptcha()
	{
		$config	=& CFactory::getConfig();
		$recaptchaEnable = $config->get('jspt_captcha_during_reg');
		if(!$recaptchaEnable)
			return true;
				
		$privatekey = $config->get('jspt_recaptcha_private_key');
		$publickey  = $config->get('jspt_recaptcha_public_key');
		
		require_once(JPATH_ROOT. DS . 'components' . DS . 'com_community' . DS . 'libraries'.DS.'recaptchalib.php');		 
		$resp = recaptcha_check_answer ($privatekey,
                              $_SERVER["REMOTE_ADDR"],
                              $_POST["recaptcha_challenge_field"],
                              $_POST["recaptcha_response_field"]);
      
		if($resp->is_valid) 
			return true;
		else
			return false;
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

	/*================== ACL RELATED FUNCTIONS  ====================*/
	function performACLCheck($ajax=0, $callArray, $args)
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
		$viewuserid =  JRequest::getVar('userid', 0 , 'GET');
		
		//global $mainframe;
		//$mainframe->enqueueMessage("view user id = ".$viewuserid." task = ".$task);
		
		if(XiPTLibraryProfiletypes::isAdmin($userId))
			return false;
		
		if(($feature && ($task || $viewuserid) && $userId)== false)
			return false;
			
		// resolve feature and task ==> into our aclFeature
		$aclViolatingRule= false;
		$aclFeature	= XiPTLibraryProfiletypes::resolvePararmeters($feature, $task, $viewuserid);
		
		//$mainframe->enqueueMessage("aclfeature = ".$aclFeature);
		
		// do acl check, is feature need to be checked ?
		if($aclFeature == false)
			return false;
		else
			$aclViolatingRule 	=	XiPTLibraryProfiletypes::aclMicroCheck($userId,$aclFeature,$viewuserid);
			
		// if not violating any rule, just return else redirect/ajaxBlock and show message.
		if($aclViolatingRule == false) 
			return false;
		
			
		$retVal = XiPTLibraryProfiletypes::aclCheckFailedBlockUser($ajax,$aclViolatingRule, $task);
		//for ajax we need to create a reponse and return it
		//if($ajax == 1 && $retVal)
		//	return $retVal;
			
		return false;
	}
	
	function resolvePararmeters($feature, $task, $viewuserid = 0)
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
				return  "aclFeatureWriteMessages";
			
			return false;
		}
		
		if($feature =='profile' && $task=='uploadavatar')
			return "aclFeatureChangeAvatar";
			
		if($feature =='profile' && $task=='privacy')
			return "aclFeatureChangePrivacy";
		
		if($feature =='profile' && $viewuserid != 0 && $task=='')
			return "aclFeatureCantVisitOtherProfile";
			
		return false;		
	}
	
	function aclCheckFailedBlockUser($ajax, $aclViolatingRule, $task)
	{
		$db		 =& JFactory::getDBO();
		
		// get all rules specific to user or his profiletype
		$query	 = 'SELECT * FROM #__community_jsptacl '
					. ' WHERE id=' 	. $db->Quote($aclViolatingRule);
		
		$db->setQuery( $query );
		$result	= $db->loadObject();
		
		assert($result);
		$message	= "";
		$redirect	= "";
		
		//foreach($results as $result)
		//{
			$message	= $result->message;
			$redirect	= CRoute::_( $result->redirecturl,false );
		//}
		
		//TODO replace few KEYS in message - e.g. __TASKCOUNT__
		if($ajax)
			return XiPTLibraryProfiletypes::aclAjaxBlock($message,$redirect);
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
	

	function aclAjaxBlock($msg,$redir)
	{
		$objResponse   	= new JAXResponse();
		$uri			= CFactory::getLastURI();
		$uri			= base64_encode($uri);

		$html 	= $msg; 

		$objResponse->addAssign('cwin_logo', 'innerHTML', JText::_('CC JSPTACL YOU ARE NOT ALLOWED TO PERFORM THIS ACTION'));
		$objResponse->addAssign('cWindowContent', 'innerHTML', $html);	
		$objResponse->addScriptCall('cWindowResize', 80);
		return $objResponse->sendResponse();
	}
	
	// final aclChecking
	function aclMicroCheck($userID , $feature , $viewuserid = 0,$objectID = 0)
	{
		// get profiletype
		assert($feature && $userID);
		
		$myPID	 = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($userID);
		$db		 = JFactory::getDBO();
		
		$otherpid	= XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($viewuserid);
		
		// get all rules specific to user or his profiletype
		//TODO : sort as per ascending task count.  
		$extraSql	= '';
		if($feature == 'aclFeatureCantVisitOtherProfile')
			$extraSql = ' AND otherpid='. $db->Quote($otherpid);
			
		$query	 = 'SELECT * FROM #__community_jsptacl '
					. ' WHERE '
					. ' pid='. $db->Quote($myPID).$extraSql
					. ' AND feature='. $db->Quote($feature)
					. ' AND published='.$db->Quote(1);
		
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
		//global $mainframe;
		//$mainframe->enqueueMessage("sql = ".$query." result = ");
		// If no rule exist for the feature then allow the user 
		if(!$results)
			return false;
		
		// get the user's count for this feature
		$owns		= XiPTLibraryProfiletypes::aclGetUsersFeatureCounts($userID, $feature);
		
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
	function aclGetUsersFeatureCounts($userid,$feature)
	{
		$groupsModel	=& CFactory::getModel('groups');
		$photoModel		=& CFactory::getModel('photos');
		$inboxModel		=& CFactory::getModel('inbox');
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
				return $inboxModel->getTotalMessageSent($userid);
				return;
			
			default :
				assert(0);
		}
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
	
	function saveUserData($userId,$fieldid,$value)
	{
		$fieldInfo = XiPTLibraryProfiletypes::getFieldInfofromFieldId($fieldid);
		if($field->type == 'profiletypes')
		{
			XiPTLibraryProfiletypes::saveFieldForUser($userId,$value,'profiletypes');	
		}
		else if($field->type == 'templates')
			XiPTLibraryProfiletypes::saveFieldForUser($userId,$value,'templates');
		
		return;
	}
	
	
	function saveFieldForUser($userId,$value,$what)
	{
		$db		=& JFactory::getDBO();
		switch($what)
		{
			case 'profiletypes':
				$extraSql = ' SET '.$db->nameQuote('profiletype') . '=' . $db->Quote($value);
				break;
			
			case 'templates':
				$extraSql = ' SET '.$db->nameQuote('template') . '=' . $db->Quote($value);
				break;
			default:
				break;
		}
			
			$strSQL	= 'UPDATE ' . $db->nameQuote('#__community_users')
					 	. $extraSql
						. ' WHERE ' . $db->nameQuote('user_id') . '=' . $db->Quote($userId);
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
}