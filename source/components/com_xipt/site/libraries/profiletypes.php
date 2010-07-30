<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
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
		XiPTLibraryUtils::XAssert($userid);

		/*XITODO : Remove the require_once, class should be auto loaded*/
		require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models'.DS.'user.php';

		/*XITODO : validate ptype before save*/
		$data             = new stdClass();
		$data->userid     = $userid;
		$data->profiletype= $profiletype;
		$data->template   = $template;
				
		/*call model through object. */
		$uModel = XiFactory :: getModel('User','site');
		$uModel->setUserData($data);
		XiPTLibraryProfiletypes::getUserData($userid, $what='PROFILETYPE', true);
		//XiPTModelUser::setUserData($data);
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
	
   	
	/**
	 * This function will not change user's profiletype
	 * It only updates user's data, do not add profiletypes
	 * @param $userid
	 * @param $oldData
	 * @param $newData
	 * @return unknown_type
	 */
	function updateUserProfiletypeFilteredData($userid, $filter, $oldData, $newData)
	{
		XiPTLibraryUtils::XAssert($userid) || JError::raiseError('XIPTERR','No User ID in '.__FUNCTION__);
		
		foreach($filter as $feature)
		{
			switch($feature)
			{
				case 'template':
					$template = $newData['template'];
					$ptype  =  XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
					XiPTLibraryProfiletypes::saveXiPTUser($userid,$ptype,$template);
					XiPTLibraryCore::updateCommunityCustomField($userid,$template,TEMPLATE_CUSTOM_FIELD_CODE);
					break;
					
				case 'jusertype' :
					$newJUtype 	= $newData['jusertype']; 
					XiPTLibraryCore::updateJoomlaUserType($userid,$newJUtype);
					break;
					
				case 'avatar' :
					$newAvatar 	= $newData['avatar'];
					XiPTLibraryCore::updateCommunityUserAvatar($userid,$newAvatar);
					break;
				
				case 'watermark' :
					$newWatermark 	= $newData['watermark']; 
					XiPTLibraryCore::updateCommunityUserWatermark($userid,$newWatermark);
					break;

				case 'group' :
					$newGroup 	= $newData['group'];
					$oldGroup	= $oldData['group'];
					XiPTLibraryCore::updateCommunityUserGroup($userid,$oldGroup, $newGroup);
					break;
				
				case 'privacy':
					$newPrivacy = $newData['privacy'];
					$newPrivacy = XiPTLibraryUtils::getPTPrivacyValue($newPrivacy);
					XiPTLibraryCore::updateCommunityUserPrivacy($userid,$newPrivacy);
					break;
					
				default:
					XiPTLibraryUtils::XAssert(0);
					JError::raiseWarning('XIPT',"Not a valid filter options  ".__FUNCTION__);
					break;
			}
		}

		//IMP : Reseting user already loaded information
		XiPTLibraryCore::reloadCUser($userid);
	}
	
	/** 
	 * This function is used to update user's profiletype
	 * and its associated data. 
	 * @param $userid
	 * @param $ptype
	 * @param $template
	 * @param $what
	 * @return unknown_type
	 */
	function updateUserProfiletypeData($userid, $ptype, $template, $what='ALL')
	{
		XiPTLibraryUtils::XAssert($userid, 'No User ID in '.__FUNCTION__, "ERROR");

		//store prev profiletype
		//IMP : must be first line, as we want to store prev profiletype
		$prevProfiletype = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
		
		if($what == 'profiletype' || $what == 'ALL')
		{
			// trigger an API for before profile type updation
			$dispatcher =& JDispatcher::getInstance();
			$userInfo['userid'] 	= $userid;
			$userInfo['oldPtype']	= $prevProfiletype;
			$userInfo['newPtype']	= &$ptype;
			
			//echo $userInfo['oldPtype']." AND ".$userInfo['newPtype'];
			/* we are sending refrence of new ptype
			* this should be validate before save 
			*/
			$dispatcher->trigger( 'onBeforeProfileTypeChange',array($userInfo));
			// validate profile type, may be changed in event triggered
			if(XiPTLibraryProfiletypes::validateProfiletype($ptype)==false)
				$ptype  = XiPTLibraryProfiletypes::getDefaultProfiletype();
		
			//set profiletype and template for user in #__xipt_users table
			if(!$template) 
				$template = XiPTLibraryProfiletypes::getProfileTypeData($ptype,'template');
			$result=XiPTLibraryProfiletypes::saveXiPTUser($userid,$ptype,$template);

			//set profiletype and template field in #__community_fields_values table
			// also change the user's type in profiletype field.
			XiPTLibraryCore::updateCommunityCustomField($userid,$template,TEMPLATE_CUSTOM_FIELD_CODE);
			XiPTLibraryCore::updateCommunityCustomField($userid,$ptype,PROFILETYPE_CUSTOM_FIELD_CODE);
			
			// trigger an API for after profile type updation
			/* send success result */
			//send the result as true
			$dispatcher->trigger( 'onAfterProfileTypeChange',array($ptype,$result));
		}

		$feature=array();
		$oldData=array();
		$newData=array();
		
		//set usertype acc to profiletype in #__user table
		if($what == 'ALL' || $what == 'jusertype')
		{
			$feature[]='jusertype';
			$oldData['jusertype']=self::getProfiletypeData($prevProfiletype,'jusertype');
			$newData['jusertype']=self::getProfiletypeData($ptype,'jusertype');
		}
			
		//set user avatar in #__community_users table
		if($what == 'ALL'  || $what == 'avatar')
		{
			$feature[]='avatar';
			$oldData['avatar'] = self::getProfiletypeData($prevProfiletype,'avatar');
			$newData['avatar'] = self::getProfiletypeData($ptype,'avatar');
		}

		//set user watermark
		if($what == 'ALL'  || $what == 'watermark')
		{
			$feature[]='watermark';
			$oldData['watermark'] = self::getProfiletypeData($prevProfiletype,'watermark');
			$newData['watermark'] = self::getProfiletypeData($ptype,'watermark');
		}
		
		//assign the default group
		if($what == 'ALL'  || $what == 'group')
		{
			$feature[]='group';
			$oldData['group'] = self::getProfiletypeData($prevProfiletype,'group');
			$newData['group'] = self::getProfiletypeData($ptype,'group');
		}
			
		//set privacy data
		if($what == 'ALL'  || $what == 'privacy')
		{
			$feature[] = 'privacy';
			$oldPrivacy	= self::getProfiletypeData($prevProfiletype,'privacy');
			$newPrivacy	= self::getProfiletypeData($ptype,'privacy');
			
			$oldData['privacy']	=$oldPrivacy;
			$newData['privacy']	= $newPrivacy;
		}
			
		self::updateUserProfiletypeFilteredData($userid,$feature,$oldData,$newData);
		return true;
	}
	

	function getDefaultProfiletype($refresh=false)
	{
		static $defaultProfiletypeID = null;
		if($defaultProfiletypeID && $refresh===false)
			return $defaultProfiletypeID;
			 
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
	function getUserData($userid, $what='PROFILETYPE', $clean=false)
	{	
		static $counter=0;
		
		static $result=array();
		if($clean)
		{
			unset($result[$userid]);
			return;
		}
		
		if(array_key_exists($userid,$result))
			return $result[$userid][strtolower($what)];
	    
		//echo "counter ".(++$counter);
		switch($what)
	    {
	        case 'PROFILETYPE':
	        	if($userid == 0 )
					return XiPTLibraryUtils::getParams('guestProfiletypeID','com_xipt', XiPTLibraryUtils::getParams('defaultProfiletypeID','com_xipt', 0));
		        $getMe	       = PROFILETYPE_FIELD_IN_USER_TABLE;
                $defaultValue  = XiPTLibraryProfiletypes::getDefaultProfiletype();
                break;
                
	        case 'TEMPLATE':
                $getMe	= TEMPLATE_FIELD_IN_USER_TABLE;
                $allTemplates = XiPTLibraryUtils::getTemplatesList();
       		    $pID          = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
       		    $defaultValue = XiPTLibraryProfiletypes::getProfileTypeData($pID,'template');

        		//else get system template
        		if(in_array($defaultValue,$allTemplates)===false)
			        $defaultValue   =  XiPTLibraryProfiletypes::getDefaultTemplate();

                break;
                
	        default :
	            JError::raiseError('XIPT-SYSTEM-ERROR','XIPT System Error');
	    }

	    
	    $db		=& JFactory::getDBO();
		$query	= 'SELECT * FROM '
				. $db->nameQuote( '#__xipt_users') . ' WHERE '
				. $db->nameQuote( 'userid') . '=' . $db->Quote( $userid );
		$db->setQuery( $query );
		
		$result[$userid]	= $db->loadAssoc();
		
		//print_r($result);
		if($db->getErrorNum()) {
				JError::raiseError( 500, $db->stderr());
		}
		
		// not a valid result OR value not set
		if(!$result || isset ($result[$userid])===false){
		    return $defaultValue;
		}
	
		return $result[$userid][strtolower($what)];
	}
	
	/**
	 * @param $id 	: profile-type ID
	 * @param $what : attribute required, default is name
	 * @return unknown_type
	 */
	/*function getProfiletypeData($id=0, $what='name')
	{
		$cache =  JFactory::getCache('com_xipt');
		return $cache->call(array('XiPTLibraryProfiletypes','_getProfiletypeData'),$id=0, $what);
	}*/
	
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
					$defaultValue	= DEFAULT_AVATAR;
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
	function _getNotSelectedFieldForProfiletype($profiletypeId,$category)
	{
		//XIPT_NONE means none , means not visible to any body
		
		$notselected = array();
		//Load all fields for profiletype
		$db			=& JFactory::getDBO();
		$query		= 'SELECT `fid` FROM ' . $db->nameQuote( '#__xipt_profilefields' )
					. ' WHERE '.$db->nameQuote('pid').'='.$db->Quote($profiletypeId)
					. ' AND '.$db->nameQuote('category').'='.$db->Quote($category);
		$db->setQuery( $query );
		$results = $db->loadResultArray();
		
		//this has been handled by loadResultArray.
//		if(!empty($results)) {
//		//create array of result profile type
//			foreach($results as $result) {
//		      $notselected[] = $result->fid;
//		 	 }
//		}
// 		return $notselected;
		return $results;
	}
	
	//call fn to update fields during registration
	function _getFieldsForProfiletype(&$fields, $selectedProfiletypeID, $from, $notSelectedFields= null)
	{
		global $mainframe;
		if(empty($selectedProfiletypeID)){
		    JError::raiseError('XIPT_ERROR','XIPT SYSTEM ERROR');
			return false;
		}
		
		if($notSelectedFields===null)
		{
			$categories=XiPTHelperProfileFields::getProfileFieldCategories();
			
			foreach($categories as $catIndex => $catInfo)
			{
				$catName 			 = $catInfo['name'];
				$notSelectedFields[$catName] = XiPTLibraryProfiletypes::_getNotSelectedFieldForProfiletype($selectedProfiletypeID,$catIndex);
			}
		}
		
		$fieldCount=count($fields);
		for($i=0 ; $i < $fieldCount ; $i++){
		    $field =& $fields[$i];
		    
		    
		    if(is_object($field))
		        $fieldId   = $field->id;
		    else
		        $fieldId   = $field['id'];

			if(in_array($fieldId, $notSelectedFields['ALLOWED']))
			{
			    unset($fields[$i]);
			    continue;
			}
			
			if(in_array($fieldId, $notSelectedFields['REQUIRED']))
			{
				if(is_object($field))
				    $field->required=0;
				else
					$field['required']=0;
			}
			
			if(in_array($fieldId, $notSelectedFields['VISIBLE']) &&  $from==='getViewableProfile')
				unset($fields[$i]);
						
			if(in_array($fieldId, $notSelectedFields['EDITABLE_AFTER_REG']) &&  $from==='getEditableProfile' && $mainframe->isAdmin()==false)
				unset($fields[$i]);

			if(in_array($fieldId, $notSelectedFields['EDITABLE_DURING_REG']) &&  $from!='getViewableProfile' &&  $from!='getEditableProfile')
				unset($fields[$i]);
				
			
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
    // or default of one of ProfileType? 
	function isDefaultAvatarOfProfileType($path,$isDefaultCheckRequired = false)
	{
		//if default check required 
		//we should not ignore case for windows 
		if($isDefaultCheckRequired)
		{
			$val1 = JString::stristr(DEFAULT_AVATAR,$path);
			$val2 = JString::stristr(DEFAULT_AVATAR_THUMB,$path);
			if( $val1 || $val2 )
				return true;
		}	
		
		static $allAvatars = null ;
		//it will improve the performance
		if($allAvatars == null)
		{
			$searchFor 		= 'avatar';
			$db			=& JFactory::getDBO();
			$query		= 'SELECT '.$db->nameQuote($searchFor)
						.' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) ;
			$db->setQuery( $query );
			$allAvatars  = $db->loadObjectList();
			if(!$allAvatars)
				return true;
		}
			
		foreach($allAvatars as $one)
		{
			if(JString::stristr($one->avatar ,$path))
				return true;
			if(JString::stristr($path, XiPTLibraryUtils::getThumbAvatarFromFull($one->avatar)))
				return true;
		}
		
		return false;
	}

	/*
	 * We do not need this function anymore
	 */
	/*function isProfileTypeDataResetRequired($userid, $check, $what='ALL')
	{
	    XiPTLibraryUtils::XAssert(0);
	}*/
	
	
    /**
     * If profiletype exist and published return true
     * else return false,
     * IMP : If empty profiletype returns false
     *
     * @param $profileTypeID
     * @return boolean
     */
    function validateProfiletype($profileTypeID, $filter=array('published'=>1))
	{
		if(empty($profileTypeID))
			return false;
		
		$allProfileTypes = XiPTLibraryProfiletypes::getProfiletypeArray($filter);
		
		if(empty($allProfileTypes))
			return false;
			
		foreach($allProfileTypes as $pType) {
			if($profileTypeID == $pType->id)
				return true;
		}
		
		return false;
	}
	
	function getParams($id,$what='params')
	{
			$config = '';
			$db			=& JFactory::getDBO();
			$query		= 'SELECT '. $db->nameQuote($what) .' FROM '
						. $db->nameQuote( '#__xipt_profiletypes' )
						. ' WHERE '.$db->nameQuote('id').'='. $db->Quote($id);
			
			$db->setQuery( $query );
			$pTypeConfig = $db->loadResult();
			if($pTypeConfig)
				$config	= new JParameter( $pTypeConfig );
			else
				$config=null;
			
			
			// Load default configuration
			$params	= $config;//new JParameter( $config->_raw );
		//}
		return $params;		
	}
	
}
