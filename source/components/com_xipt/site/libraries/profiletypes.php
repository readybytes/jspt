<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

class XiPTLibraryProfiletypes
{

	/**
	 * This function stores the user object
	 * @param $userid
	 * @param $profiletype
	 * @param $template
	 * @return unknown_type
	 */
	function saveXiPTUser($userid,$profiletype,$template)
	{
		assert($userid);
		require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models'.DS.'user.php';
		
		$data             = new stdClass();
		$data->userid     = $userid;
		$data->profiletype= $profiletype;
		$data->template   = $template;
		
		//TODO: call model through object.
		XiPTModelUser::setUserData($data);
	}
	
    function saveXiPTUserField($userId,$value,$what)
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
	
    /*
	 * TODO : CODREV , Lots of Testing Required here
	 * */
	function updateProfileFieldsEvent($userId, $fields)
	{
		if(!$fields || $userId <= 0)
			return;
			
		$profileType	= 0;
		$template		= '';
		
		// collect template and profiletype specified
		foreach($fields as $id => $value){
			$fieldInfo = XiPTLibraryProfiletypes::getFieldObject($id);
			if($fieldInfo->type == PROFILETYPE_FIELD_NAME)
				$profileType = $value;
		
			if($fieldInfo->type == TEMPLATE_FIELD_NAME)
				$template 	= $value;
		}
		
		// if profiletype is different then set profiletype
		$oldPTypeId = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($userId);
		if($profileType && $oldPTypeId != $profileType)
				XiPTLibraryCore::setProfileDataForUserID($userId,$value,'ALL');
				
		// set template as per his choice
		$oldTemplate = XiPTLibraryProfiletypes::getTemplateOfuser($userId);
		if($template && $template != $oldTemplate)
			XiPTLibraryProfiletypes::saveFieldForUser($userId,$template,TEMPLATE_FIELD_NAME);

		return true;
	}
    
	
    //         ALL means you are from register
	function updateUserProfiletypeData($userid, $ptype, $template, $what='ALL')
	{
		assert($userid) || JError::raiseError('XIPT SYSTEM ERROR','No User ID in '.__FUNCTION__);
		//store prev profiletype
		//CODREV : must be first line, as we want to store prev profiletype
		$prevProfiletype = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
		
		if($what == 'profiletype' || $what == 'ALL')
		{
			//1.set profiletype and template for user in #__xipt_users table
			if(!$template)
			    $template = XiPTLibraryProfiletypes::getProfileTypeData($ptype,'template');
			XiPTLibraryProfiletypes::saveXiPTUser($userid,$ptype,$template);

			//4.set profiletype and template field in #__community_fields_values table
			// also change the user's type in profiletype field.
			XiPTLibraryCore::updateCommunityCustomField($userid,$template,TEMPLATE_CUSTOM_FIELD_CODE);
			XiPTLibraryCore::updateCommunityCustomField($userid,$ptype,PROFILETYPE_CUSTOM_FIELD_CODE);
			
		}
		
		if($what == 'ALL')
		{
			//2.set usertype acc to profiletype in #__user table
			XiPTLibraryCore::updateJoomlaUserType($userid,$ptype);
			
			//3.set user avatar in #__community_users table
			XiPTLibraryCore::updateCommunityUserAvatar($userid,$ptype);
			
			// assign the default group
			XiPTLibraryCore::updateCommunityUserGroup($userid,$ptype,$prevProfiletype);
			
			//5.set privacy data
			XiPTLibraryCore::updateCommunityUserPrivacy($userid,$ptype);
		}
		
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
	

	
    
  
    
	// get default profiletype from config
	function getDefaultProfiletype()
	{
		$defaultProfiletypeID = XiPTLibraryUtils::getParams('defaultProfiletypeID','com_xipt');
		
		if(!$defaultProfiletypeID)
		{
			echo XiPTLibraryUtils::getParams()->render();
		    JError::raiseWarning('DEF_PTYPE_REQ','DEFAULT PROFILE TYPE REQUIRED');
		}
		    
		return  $defaultProfiletypeID;
	}
	
	function getDefaultTemplate()
	{
        $config	        =& CFactory::getConfig();
	    $defaultValue   =  $config->get('template');
	    return $defaultValue;
	}
	
	
	//return ptype name from id
	function getProfiletypeName( $id = 0)
	{
	    // in Custom field and XiPT table they can have pID=0
	    if($id==0)
            $id=XiPTLibraryProfiletypes::getDefaultProfiletype();
		
		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('name').' FROM ' . $db->nameQuote( '#__xipt_profiletypes' )
					. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id) ;
		$db->setQuery( $query );
		$val = $db->loadResult();
		return $val;
	}

	//return array of all published profile type id
	function getProfiletypeArray($filter='')
	{
		//TODO : we need to add $visible pTypes as per request.
		$db			=& JFactory::getDBO();
		$where = '';
		
		if($filter){
			$i=0;
			foreach($filter as $key => $val){
				if($i)
					$where .= ' AND ';
				else
					$where  = ' WHERE ';
				
				$where .=  " ".$db->nameQuote($key)."=".$db->Quote($val) . " ";
				$i++;
			}
		}
		
		$query		= ' SELECT *'
					. ' FROM ' . $db->nameQuote( '#__xipt_profiletypes' )
					. $where
					. ' ORDER BY '.$db->nameQuote('ordering');
		$db->setQuery( $query );
		
		$profiletypes = $db->loadObjectList();
		
		return $profiletypes;
	}
	

	/**
	 * 	 This function return's user's data from tables
	 * @param $userid
	 * @param $what
	 * @return unknown_type
	 */
	function getUserData($userid, $what='PROPFILETYPE')
	{
	    switch($what)
	    {
	        case 'PROFILETYPE':
                $getMe	       = PROFILETYPE_FIELD_IN_USER_TABLE;
                $defaultValue  = XiPTLibraryProfiletypes::getDefaultProfiletype();
                break;
                
	        case 'TEMPLATE':
                $getMe	= TEMPLATE_FIELD_IN_USER_TABLE;
                $allTemplates = XiPTLibraryUtils::getTemplatesList();
       		    $pID          = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
       		    $defaultValue = XiPTLibraryProfiletypes::getProfileTypeData($pID,'template');

        		//else get system template
        		if(in_array($defaultValue,$allTemplates)==false)
			        $defaultValue   =  XiPTLibraryProfiletypes::getDefaultTemplate();

                break;
                
	        default :
	            JError::raiseError('XIPT_ERR','XIPT System Error');
	    }

	    $db		=& JFactory::getDBO();
		$query	= 'SELECT ' . $db->nameQuote($getMe) . ' FROM '
				. $db->nameQuote( '#__xipt_users') . ' WHERE '
				. $db->nameQuote( 'userid') . '=' . $db->Quote( $userid );
		$db->setQuery( $query );
		
		$result	= $db->loadResult();
		
		if($db->getErrorNum()) {
				JError::raiseError( 500, $db->stderr());
		}
		
		// not a valid result OR value not set
		if(!$result){
		    //TODO: set ProfileType is nothing exist
		    $result = $defaultValue;
		}
		    
		return $result;
	}
	
	/**
	 * @param $id 	: profile-type ID
	 * @param $what : attribute required, default is name
	 * @return unknown_type
	 */
	function getProfiletypeData($id=0, $what='name')
	{

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
					$defaultValue	= 'default';
					break;
			case 'jusertype' :
					$searchFor 		= 'jusertype';
					$defaultValue	= 'Registered';
					break;
			case  'avatar':
					$searchFor 		= 'avatar';
					$defaultValue	= 'components/com_community/assets/default.jpg';
					break;
			case  'watermark':
					$searchFor 		= 'watermark';
					$defaultValue	= '';
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
			case	'parent':
					$searchFor 		= 'parent';
					$defaultValue	= 0;
					break;
			default	:
					JError::raiseError('XIPT_ERR','XIPT System Error');
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
	
	// returns all user of profiletype
	function getAllUsers($pid)
	{
		$db	=& JFactory::getDBO();
		
		$defaultPtype = self::getDefaultProfiletype();
		if($defaultPtype == $pid)
			$defaultPtypeCheck = ' OR `profiletype`='.$db->Quote(0);
		else
			$defaultPtypeCheck = ' ';
			
		$query = ' SELECT `userid` FROM `#__xipt_users`'
				.' WHERE `profiletype`='.$db->Quote($pid)
				. $defaultPtypeCheck;
				
		$db->setQuery($query);
		$result = $db->loadResultArray();
		
		if($db->getErrorNum()){
					JError::raiseError( 500, $db->stderr());
		}
		
		return $result;
	}
	
    //    assuming that by default all fields are available to all profiletype
	//if any info is stored in table means that field is not available to that profiletype
	//we store info in opposite form
	function _getNotSelectedFieldForProfiletype($profiletypeId)
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
	
	//call fn to update fields during registration
	function _getFieldsForProfiletype(&$fields, $selectedProfiletypeID, $from)
	{
		if(empty($selectedProfiletypeID)){
		    JError::raiseError('XIPT_ERROR','XIPT SYSTEM ERROR');
			return false;
		}
			
		$notSelectedFields = XiPTLibraryProfiletypes::_getNotSelectedFieldForProfiletype($selectedProfiletypeID);

		$i=0;
		$fieldCount=count($fields);
		for($i=0 ; $i < $fieldCount ; $i++){
		    $field =& $fields[$i];
		    
		    if(is_object($field))
		        $fieldId   = $field->id;
		    else
		        $fieldId   = $field['id'];
		        
			if(in_array($fieldId, $notSelectedFields))
			{
			    unset($fields[$i]);
			}
		}
		$fields = array_values($fields);
		return true;
	}
	
			
	//call fn to get fields related to ptype in getviewable and geteditable profile fn
	function filterCommunityFields($userid, &$fields, $from)
	{
	    //durin loadAllfields no user id avaialble
	    // so we pick the pType from registration 
	    if($userid == 0 )
	        $pTypeID = XiPTFactory::getLibraryPluginHandler()->getRegistrationPType();
	    else
	        $pTypeID = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
     
	    // filter the fields as per profiletype
	    XiPTLibraryProfiletypes::_getFieldsForProfiletype($fields,$pTypeID, $from);
	}
	
	
    // Checks if given avatar is default profiletype avatar
    // or default of one of ProfileType
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
			if(Jstring::stristr($path, XiPTLibraryUtils::getThumbAvatarFromFull($one->avatar)))
				return true;
			if($isDefaultCheckRequired && ( Jstring::stristr('components/com_community/assets/default.jpg' ,$path)
				|| Jstring::stristr('components/com_community/assets/default_thumb.jpg' ,$path)))
				return true;
		}
		
		return false;
	}

	function isProfileTypeDataResetRequired($userid, $check, $what='ALL')
	{
	    // we can not discard user uploaded avatar
	    if($check == 'avatar')
	    {
	        $oldAvatar  = XiPTLibraryCore::getUserDataFromCommunity($userid, 'avatar');
			$isDefault	= XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($oldAvatar,true);
			
			//CODREV : Check if watermark is enable if true then return true
			//now check here watermark required feature also
			//if avatar is user also then we have to add watermark for new profiletype ,
			//for which we have to update new watermark with user image
			if(XiPTLibraryUtils::getParams('show_watermark','com_xipt')
				&& !$isDefault)
				return true;
			
			return $isDefault;
	    }
	    
	    // You are changing all things, you should reset other attributes
		if($what == 'ALL')
			return true;
			
		// you are changing profiletype, you should reset other attributes
		if($what == 'profiletype')
			return true;

        //default answer is NO
		return false;
	}
	
	
    /**
     * If profiletype exist and published return true
     * else return false,
     * IMP : If empty profiletype returns false
     *
     * @param $profileTypeID
     * @return boolean
     */
    function validateProfiletype($profileTypeID)
	{
		if(empty($profileTypeID))
			return false;
		
		$allProfileTypes = XiPTLibraryProfiletypes::getProfiletypeArray(array('published'=>1));
		
		if(empty($allProfileTypes))
			return false;
			
		foreach($allProfileTypes as $pType) {
			if($profileTypeID == $pType->id)
				return true;
		}
		
		return false;
	}
	
	/*@param $parentId = take profiletype id for which we want to get child list
	return array of childs and child of child
	for getting all level childs send -1 in depth
	if $allInfo is true then return all information for profiletype array 
	*/
	function getChildArray($parentId,$level=0,$depth=-1,$allInfo=true)
	{
		$childArray = array();
		if($level == $depth)
			return $childArray;
		$childLists = self::getChilds($parentId);
		if(empty($childLists))
			return $childArray;

		if(!empty($childLists))
			foreach($childLists as $child) {
				if(true == $allInfo)
					$childArray[] = $child;
				else
					$childArray[] = $child->id;
				$childArray = array_merge($childArray
										,self::getChildArray($child->id,$level+1,$depth,$allInfo));
			}
		
		return $childArray;
	}
	
	
	function getChilds($id=0)
	{
		$filter = array('parent'=>$id);
		$profiletypes=self::getProfiletypeArray($filter);
		return $profiletypes;
	}
	
	
	function getParentArray($childId=0,$level=0,$depth=-1)
	{
		$parentArray = array();
		
		if(0 == $childId)
			return $parentArray;	
		
		if($level == $depth)
			return $parentArray;
		
		$selfInfo = self::getProfiletypeArray(array('id'=>$childId));
		
		if(empty($selfInfo))
			return $parentArray;
		
		if(0 == $selfInfo[0]->parent)
			return $parentArray;

		$parentInfo = self::getProfiletypeArray(array('id'=>$selfInfo[0]->parent));
		if(!empty($parentInfo))
			$parentArray[] = $parentInfo[0];
		$parentArray = array_merge($parentArray
										,self::getParentArray($selfInfo[0]->parent,$level+1,$depth));
		
		return $parentArray;
	}
	
	
	
	/*//function get profiletype id for which we want to calulate siblings
	//return sibling array*/
	function getSiblings($profiletypeId)
	{
		assert($profiletypeId);
		$filter= array('id'=> $profiletypeId);
		$ptypeInfo = self::getProfiletypeArray($filter);
		$siblings = array();
		$siblings = self::getChilds($ptypeInfo[0]->parent);
		return $siblings;
	}
	

	function getDepth($profiletypeId)
	{
		assert($profiletypeId);
		$parentHirerchy = array();
		$parentHirerchy = self::getParentArray($profiletypeId,0,-1);
		return count($parentHirerchy);
	}

	function getParams($id)
	{
			$config = '';
			$db			=& JFactory::getDBO();
			$query		= 'SELECT '. $db->nameQuote('params') .' FROM '
						. $db->nameQuote( '#__xipt_profiletypes' )
						. ' WHERE '.$db->nameQuote('id').'='. $db->Quote($id);
			
			$db->setQuery( $query );
			$pTypeConfig = $db->loadResult();
			if($pTypeConfig)
				$config	= new JParameter( $pTypeConfig );			
			
			// Load default configuration
			$params	= $config;//new JParameter( $config->_raw );
		//}
		return $params;		
	}
	
}
