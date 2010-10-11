<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptLibProfiletypes
{
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
		XiptHelperUtils::XAssert($userid) || XiptError::raiseError('XIPTERR','No User ID in '.__FUNCTION__);
		$uModel = XiptFactory::getInstance('Users','model');
		
		foreach($filter as $feature)
		{
			switch($feature)
			{
				case 'template':
					$template = $newData['template'];
					$ptype    =  XiptLibProfiletypes::getUserData($userid,'PROFILETYPE');
					$uModel->save(	array('userid' => $userid,'profiletype'=>$ptype,'template'=>$template),
								 	$userid
								 );
					XiptLibJomsocial::updateCommunityCustomField($userid,$template,TEMPLATE_CUSTOM_FIELD_CODE);
					break;
					
				case 'jusertype' :
					$newJUtype 	= $newData['jusertype']; 
					XiptLibJomsocial::updateJoomlaUserType($userid,$newJUtype);
					break;
					
				case 'avatar' :
					$newAvatar 	= $newData['avatar'];
					XiptLibJomsocial::updateCommunityUserDefaultAvatar($userid,$newAvatar);
					break;
				
				case 'watermark' :
					$newWatermark 	= $newData['watermark']; 
					XiptLibJomsocial::updateCommunityUserWatermark($userid,$newWatermark);
					break;

				case 'group' :
					$newGroup 	= $newData['group'];
					$oldGroup	= $oldData['group'];
					XiptLibJomsocial::updateCommunityUserGroup($userid,$oldGroup, $newGroup);
					break;
				
				case 'privacy':
					$newPrivacy = $newData['privacy'];
					$registry	= JRegistry::getInstance( 'xipt' );
					$registry->loadINI($newPrivacy,'xipt-privacyparams');
					$newPrivacy = $registry->toArray('xipt-privacyparams');
					XiptLibJomsocial::updateCommunityUserPrivacy($userid,$newPrivacy);
					break;
					
				default:
					XiptHelperUtils::XAssert(0);
					XiptError::raiseWarning('XIPT',"Not a valid filter options  ".__FUNCTION__);
					break;
			}
		}

		//IMP : Reseting user already loaded information
		XiptLibJomsocial::reloadCUser($userid);
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
		XiptHelperUtils::XAssert($userid, 'No User ID in '.__FUNCTION__, "ERROR");
		$uModel = XiptFactory::getInstance('Users','model');
		//store prev profiletype
		//IMP : must be first line, as we want to store prev profiletype
		$prevProfiletype = XiptLibProfiletypes::getUserData($userid,'PROFILETYPE');
		
		if($what == 'profiletype' || $what == 'ALL')
		{
			// trigger an API for before profile type updation
			$dispatcher = JDispatcher::getInstance();
			$userInfo['userid'] 	= $userid;
			$userInfo['oldPtype']	= $prevProfiletype;
			$userInfo['newPtype']	= &$ptype;
			
			/* we are sending refrence of new ptype
			* this should be validate before save 
			*/
			$dispatcher->trigger( 'onBeforeProfileTypeChange',array($userInfo));
			
			// validate profile type, may be changed in event triggered
			if(XiptLibProfiletypes::validateProfiletype($ptype)==false)
				$ptype  = XiptLibProfiletypes::getDefaultProfiletype();
		
			if(!$template) 
				$template = XiptLibProfiletypes::getProfileTypeData($ptype,'template');
				
			//set profiletype and template for user in #__xipt_users table	
			$result = $uModel->save(	array('userid' => $userid,'profiletype'=>$ptype,'template'=>$template),
								 	$userid
								 );

			//set profiletype and template field in #__community_fields_values table
			// also change the user's type in profiletype field.
			XiptLibJomsocial::updateCommunityCustomField($userid,$template,TEMPLATE_CUSTOM_FIELD_CODE);
			XiptLibJomsocial::updateCommunityCustomField($userid,$ptype,PROFILETYPE_CUSTOM_FIELD_CODE);
			
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
	

	function getDefaultProfiletype()
	{		
//		static $defaultProfiletypeID = null;
//		if($defaultProfiletypeID && $refresh===false)
//			return $defaultProfiletypeID;
//		
		$defaultProfiletypeID = XiptFactory::getParams('defaultProfiletypeID');
		if($defaultProfiletypeID)
			return  $defaultProfiletypeID;
		
		echo XiptFactory::getParams()->render();
		XiptError::raiseWarning('DEF_PTYPE_REQ','DEFAULT PROFILE TYPE REQUIRED');
	}
	
	
	function getDefaultTemplate()
	{
		$config	        = CFactory::getConfig();
	    $defaultValue   =  $config->get('template');
	    return $defaultValue;
	}
			
	function getProfiletypeName( $id = 0)
	{
	    // in Custom field and Xipt table they can have pID=0
	    if($id==0)
            $id=XiptLibProfiletypes::getDefaultProfiletype();
		
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
		//XITODO : we need to add $visible pTypes as per request.move this to model
		$db			= JFactory::getDBO();
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
	//XITODO : move to user model
	function getUserData($userid, $what='PROFILETYPE', $clean=false)
	{	
//		static $counter=0;
		static $result=array();
		if($clean)
		{
			unset($result[$userid]);
		}
		
//		if(array_key_exists($userid,$result))
//			return $result[$userid][strtolower($what)];
	    
//		echo "counter ".(++$counter);
		switch($what)
	    {
	        case 'PROFILETYPE':
	        	if($userid == 0 )
					return XiptFactory::getParams('guestProfiletypeID', XiptFactory::getParams('defaultProfiletypeID', 0));
		        $getMe	       = PROFILETYPE_FIELD_IN_USER_TABLE;
                $defaultValue  = XiptLibProfiletypes::getDefaultProfiletype();
                break;
                
	        case 'TEMPLATE':
                $getMe	= TEMPLATE_FIELD_IN_USER_TABLE;
                $allTemplates = XiptHelperJomsocial::getTemplatesList();
       		    $pID          = XiptLibProfiletypes::getUserData($userid,'PROFILETYPE');
       		    $defaultValue = XiptLibProfiletypes::getProfileTypeData($pID,'template');

        		//else get system template
        		if(in_array($defaultValue,$allTemplates)===false)
			        $defaultValue   =  XiptLibProfiletypes::getDefaultTemplate();

                break;
                
	        default :
	            XiptError::raiseError('XIPT-SYSTEM-ERROR','XIPT System Error');
	    }
			
		if($userid >= 62){
		    $db		= JFactory::getDBO();
			$query	= 'SELECT * FROM '
					. $db->nameQuote( '#__xipt_users') . ' WHERE '
					. $db->nameQuote( 'userid') . '=' . $db->Quote( $userid );
			$db->setQuery( $query );
			
			$result[$userid]	= $db->loadAssoc();
			
			if($db->getErrorNum()) {
				XiptError::raiseError( 500, $db->stderr());
			}
		}
		
		//print_r($result);
		
		
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
		return $cache->call(array('XiptLibProfiletypes','_getProfiletypeData'),$id=0, $what);
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
					XiptError::raiseError('XIPT_ERR','XIPT System Error');
		}
	
		if($id==0)
			return $defaultValue;
			
		$db			= JFactory::getDBO();
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
		$db	= JFactory::getDBO();
		
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
					XiptError::raiseError( 500, $db->stderr());
		}
		
		return $result;
	}
		
	//call fn to get fields related to ptype in getviewable and geteditable profile fn
	function filterCommunityFields($userid, &$fields, $from)
	{
	    //durin loadAllfields no user id avaialble
	    // so we pick the pType from registration 
	    if($userid == 0 )
	        $pTypeID = XiptFactory::getLibraryPluginHandler()->getRegistrationPType();
	    else
	        $pTypeID = XiptLibProfiletypes::getUserData($userid,'PROFILETYPE');
     
	    // filter the fields as per profiletype
		$model = XiptFactory::getInstance('Profilefields','model');
	    $model->getFieldsForProfiletype($fields,$pTypeID, $from);
	}
	
	
    // Checks if given avatar is default profiletype avatar
    // or default of one of ProfileType? 
	function isDefaultAvatarOfProfileType($path, $isDefaultCheckRequired = false)
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
			$searchFor 	= 'avatar';
			$db			= JFactory::getDBO();
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
			if(JString::stristr($path, XiptHelperImage::getThumbAvatarFromFull($one->avatar)))
				return true;
		}
		
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
    function validateProfiletype($profileTypeID, $filter=array('published'=>1))
	{
		if(empty($profileTypeID))
			return false;
		
		$allProfileTypes = XiptLibProfiletypes::getProfiletypeArray($filter);
		
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
		$model = XiptFactory::getInstance('Profiletypes','model');
		$params = $model->loadParams($id,$what='params');
		return $params;		
	}
	
}