<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// include files, as we are here from plugin
// so files might not be included for non-component events
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

//@TODO: Write language file
//@TODO : check ptypeid in session in registerProfile fn also

//This class should be only access from it's static object.
class XiPTLibraryPluginHandler
{
	private $mySess ;
	private $mainframe;


	function __construct()
	{
		global $mainframe;
		$this->mainframe =& $mainframe;

		$this->mySess = & JFactory::getSession();
	}

	//if value exist in session then return ptype else return false
	function isPTypeExistInSession()
	{
		$aecExists 		= XiPTLibraryAEC::_checkAECExistance();
		$integrateAEC   = XiPTLibraryUtils::getParams('aec_integrate','com_xipt',0);
		if($aecExists && $integrateAEC)
		{
			$data  = XiPTLibraryAEC::getProfiletypeInfoFromAEC() ;
			return $data['profiletype'];
		}
		
		if($this->mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') == false)
		    return 0;

		return $this->mySess->get('SELECTED_PROFILETYPE_ID', 0, 'XIPT');
	}

	/**
	 * Collect profileType from session,
	 * is session does not have profiletype, return default one
	 *
	 * @return int
	 */
	function getRegistrationPType()
	{
		//get ptype from session
		$selectedProfiletypeID = $this->isPTypeExistInSession();

		// pType exist in session
		if($selectedProfiletypeID)
			return $selectedProfiletypeID;

		//no pType in session, return default value
		$defaultProfiletypeID = XiPTLibraryProfiletypes::getDefaultProfiletype();

		return $defaultProfiletypeID;
	}


	function setDataInSession($what,$value)
	{
		$this->mySess->set($what,$value, 'XIPT');
		return true;
	}

	function getDataInSession($what,$defaultValue)
	{
		if($this->mySess->has($what,'XIPT'))
			return $this->mySess->get($what,$defaultValue, 'XIPT');
		else
			return null;
	}
	
	function resetDataInSession($what)
	{
		$this->mySess->clear($what,'XIPT');
		return true;
	}
	
	
	
	function cleanRegistrationSession()
	{
	    $this->mySess->clear('SELECTED_PROFILETYPE_ID','XIPT');
	}

	//============================ Community Events=========================

	function onAfterConfigCreate(&$config)
	{
	    return XiPTLibraryCore::updateCommunityConfig($config);
	}

	function onAjaxCall(&$func, &$args , &$response)
	{
		$callArray	= explode(',', $func);

		//perform Access checks
		$ajax = true;
		$this->performACLCheck($ajax, $callArray, $args);

		// If we come here means ACL Check was passed
		$controller	=	$callArray[0];
		$function	=	$callArray[1];
	
		if($controller	==	'connect')
		{
			switch($function)
			{
				case 'ajaxCheckEmail' 	 :
					return XiPTLibraryUtils::ajaxCheckEmailDuringFacebook($args,$response);
				case 'ajaxCheckUsername' :
					return XiPTLibraryUtils::ajaxCheckUsernameDuringFacebook($args,$response);
				case 'ajaxShowNewUserForm' :
					return XiPTLibraryUtils::ajaxShowNewUserForm($args,$response);
				case 'ajaxUpdate' :
					return XiPTLibraryUtils::ajaxUpdate($args,$response);
			}
		}
		
		if($controller	==	'register')
		{
			switch($function)
			{
				case 'ajaxCheckEmail' 	 :
				case 'ajaxCheckUserName' :
					return XiPTLibraryUtils::$function($args,$response);
			}
		}

		// Checks to stop Apps addition not allowed
		if($controller=='apps' && $function=='ajaxAdd')
		{
		    $my				=& JFactory::getUser();

		    //no filtering for guests
		    if(0 == $my->id)
		        return true;

		    $profiletype = XiPTLibraryProfiletypes::getUserData($my->id,'PROFILETYPE');
		    return XiPTLibraryApps::filterAjaxAddApps($args[0],$profiletype,$response);
		}

		// we do not want to interfere, go ahead JomSocial
		return true;
	}

	
	/*Function will call replacement controller for any community controller
	 * we are doing this for facebook ( connect ) controller
	 
	function onBeforeControllerCreate(&$args)
	{

	}
	*/
	

	/**
	 * This function will store user's registration information
	 * in the tables, when Community User object is created
	 * @param $cuser
	 * @return true
	 */
	function onProfileCreate($cuser)
	{
		$userid	= $cuser->_userid;

		return self::storeUser($userid);
	}
	
	
	/**
	 * This function will store user's registration information
	 * in the tables, when User object is created
	 * @param $cuser
	 * @return true
	 */
	function onAfterStoreUser($args)
	{
		/*args[1] contain isNew user
		 * args[2] = success
		 * args[3] = error
		 * so we will check that if user is old 
		 * or error in save or not success then we will return
		 */
		if($args[1] == false || $args[2] == false || $args[3] == true) {
			self::cleanRegistrationSession();
			return true;
		}

		return self::storeUser($args[0]['id']);
	}
	
	/*function will delete user entry from xipt_users table also */
	function onAfterDeleteUser($args)
	{
		/*args[1] = success
		 * args[2] = error
		 * so we will check that if user has beed successfully deleted
		 * then we will proced else
		 * or error in delete then we will return
		 */
		if($args[1] == false || $args[2] == true)
			return true;

		return self::deleteUser($args[0]['id']);
	}

	
	function deleteUser($userid)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT * FROM '. $db->nameQuote('#__xipt_users')
				. ' WHERE '.$db->nameQuote('userid').'='.$db->Quote($userid);

		$db->setQuery( $query );
		$result	= $db->loadObject();
		
		if(empty($result))
			return true;
			
		$query	= 'DELETE FROM '. $db->nameQuote('#__xipt_users')
				. ' WHERE '.$db->nameQuote('userid').'='.$db->Quote($userid);

		$db->setQuery( $query );
		if($db->query())
			return true;
			
		return false;
	}
	

	function storeUser($userid)
	{
		// find pType of user
		$profiletypeID = self::getRegistrationPType();

		// need to set everything
		XiPTLibraryProfiletypes::updateUserProfiletypeData($userid, $profiletypeID,'', 'ALL');

		//clean the session
		self::cleanRegistrationSession();

		return true;
	}


	/**
	 * This function will ensure that who is not allowed to change template
	 * or profiletype the data should not be saved.
	 *
	 * @param $userId
	 * @param $fieldValueCodes
	 * @return true
	 */
	function onBeforeProfileUpdate($userid, &$fieldValueCodes)
	{
		// We NEVER send false from here. If profiletype should not be changed then 
		// we simply store previous values. so correct values are always there during the 
		// after event
		
		// TODO : array_key_exists Check for both fields exist in array or not
		$profileTypeValue =& $fieldValueCodes[PROFILETYPE_CUSTOM_FIELD_CODE];
		$templateValue    =& $fieldValueCodes[TEMPLATE_CUSTOM_FIELD_CODE];
		
		global $mainframe;
		// While editing in backend do not check for verification Dont run in admin
		if ($mainframe->isAdmin())
			return true;
			
		// the use is admin, might be editing from frontend return true
		if(XiPTLibraryUtils::isAdmin($userid))
			return true;

		// user is allowed or not.
        $allowToChangePType    = XiPTLibraryUtils::getParams('allow_user_to_change_ptype_after_reg','com_xipt',0);
        $allowToChangeTemplate = XiPTLibraryUtils::getParams('allow_templatechange','com_xipt',0);

        // not changing anything get data from table and set it
		if(0 == $allowToChangeTemplate || $templateValue==''){
			//reset to old users value
			$templateValue = XiPTLibraryProfiletypes::getUserData($userid,'TEMPLATE');
			
			//if user is changing profiletype then we should pick the template as per profiletype
			$oldPtype = XiPTLibraryProfiletypes::getUserData($userid, 'PROFILETYPE');
			if($allowToChangePType && $oldPtype != $profileTypeValue)
				$templateValue = XiPTLibraryProfiletypes::getProfiletypeData($profileTypeValue, 'template');
		}

		// not allowed to change profiletype, get data from table and set it
		if(0 == $allowToChangePType || $profileTypeValue==0){
			$profileTypeValue = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
		}

		return true;
	}

	/**
	 * The user data have been saved.
	 * We will save user's data (profiletype and template) into XiPT tables
	 * @param $userId
	 * @param $saveSuccess
	 * @return unknown_type
	 */
	function onAfterProfileUpdate($userid, $saveSuccess)
	{
	    // data was not saved, do nothing
	    if(false == $saveSuccess)
	        return true;

	    // the JomSocial already store values in field tables
	    // now we need to apply that information to our tables
	    $cuser        = CFactory::getUser($userid);
	    $profiletype  = $cuser->getInfo(PROFILETYPE_CUSTOM_FIELD_CODE);
	    $template     = $cuser->getInfo(TEMPLATE_CUSTOM_FIELD_CODE);

	    //update profiletype only
	    XiPTLibraryProfiletypes::updateUserProfiletypeData($userid,$profiletype,$template,'ALL');
	    
	    //update template seperately
	    $filter[] = 'template';
	    $newData['template']= $template;
	    XiPTLibraryProfiletypes::updateUserProfiletypeFilteredData($userid,$filter,null,$newData);
	    return true;
	}

	/*
	 * This function require to protect deletion of
	 * default avatar of profiletype because JS
	 * delete non-default avatar when user change his avatar
	 * so in that case if that user has any ptype default avatar
	 * then our ptype avatar will be deleted.
	 * 
	 * This function also ensures that when remove pciture is used by admin
	 * on custom avatar, then we need to add default avatar of profiletype to user
	 * not the jomsocial default avatar
	 */
	function onProfileAvatarUpdate($userid, &$old_avatar_path, &$new_avatar_path)
	{
		// When admin is removing a user's avatar
		// we need to apply default avatar of profiletype
		$isAdmin = XiPTLibraryUtils::isAdmin(JFactory::getUser()->id);
		$view = JRequest::getVar('view','','GET');
		$task = JRequest::getVar('task','','GET');
		//
		if($isAdmin && $view == 'profile' && $task == 'removepicture')
		{
			//setup $new_avatar
			$ptype = XiPTLibraryProfiletypes::getUserData($userid, 'PROFILETYPE');
			$avatar = XiPTLibraryProfiletypes::getProfiletypeData($ptype, 'avatar');
			//if users avatar is custom avatar then thumb is stored as thumb_XXXX.png
			//else if it is a default avatar(JomSocial OR Profiletype) then stored as XXX_thumb.png
			//HERE the new_avatar will be default jomsocial avatar so search _thumb 
			$thumb = JString::stristr($new_avatar_path,'thumb');
			if($thumb)
				$new_avatar_path = XiPTLibraryUtils::getThumbAvatarFromFull($avatar);
			else
				$new_avatar_path = $avatar;
		}
		
		//check if avatar is ptype default avatar
		if(XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($old_avatar_path,false)){
			//HERE we should search for _thumb, not for thumb_
			$thumb = JString::stristr($old_avatar_path,'thumb');
			if ($thumb)
				$old_avatar_path = DEFAULT_AVATAR_THUMB;
			else
				$old_avatar_path = DEFAULT_AVATAR;
		}		
		
		//Now apply watermark to images
		//	for that we don't require to add watermark
		if(XiPTLibraryUtils::getParams('show_watermark','com_xipt')==false)
			return true;
					
		//check if uploadable avatar is not default ptype avatar
		if(XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($new_avatar_path,true))
			return true;
		
		//check what is new image , if thumb or original
		if(JString::stristr($new_avatar_path,'thumb'))
			$what = 'thumb';
		else
			$what = 'avatar';
		
		$watermarkInfo = XiPTLibraryUtils::getWatermark($userid);
		if(false == $watermarkInfo)
			return true;
			
		XiPTLibraryUtils::addWatermarkOnAvatar($userid,$new_avatar_path,$watermarkInfo,$what);
		return true;
	}


	/**
	 * This function removes not allowed community apps form dispatcher
	 * as per user's profiletype
	 * @return true
	 */
	function onAfterAppsLoad()
	{
		// skip these calls from backend
		global $mainframe;
		if($mainframe->isAdmin())
			return;

		$dispatcher =& JDispatcher::getInstance();
		/* TODO : when A is viewing B's profile then
		 * we restrict all A's app on B's profile too.
		 * so currently we are restricting all apps for currently logged in user
		 * $userid    = JRequest::getVar('userid',0);
		 * do nothing for guest
		 *
		 */
		$selfUserid    = JFactory::getUser()->id;
		$othersUserid  = JRequest::getVar('userid',$selfUserid);
		
		// restrict apps for logged in user only
		if(!$selfUserid)
		    return true;

		$selfProfiletype 	= XiPTLibraryProfiletypes::getUserData($selfUserid, 'PROFILETYPE');
		$othersProfiletype 	= XiPTLibraryProfiletypes::getUserData($othersUserid, 'PROFILETYPE');
		$blockDisplayAppOfSelf = XiPTLibraryUtils::getParams('jspt_block_dis_app_visit_pro','com_xipt', 0);
		
		/* #1: block the display application of logged in user if the above param is set to yes
		   #2: otherwise block display application of user whose profile is being visited
		   #3: block the functional application of logged in user
		*/ 		
		if($blockDisplayAppOfSelf)
			XiPTLibraryApps::filterCommunityApps($dispatcher->_observers, $selfProfiletype, true);
		else
			XiPTLibraryApps::filterCommunityApps($dispatcher->_observers, $othersProfiletype, true);

		XiPTLibraryApps::filterCommunityApps($dispatcher->_observers, $selfProfiletype,	  false);
		
	    return true;
	}


	//==================== Joomla Events=======================
	/*
	 * This function intercept registration call to jomSocial
	 * - if profiletype-selection registration not allowed then simply return
	 * - if above is enabled then check pType already exist in session
	 * 		-- Yes -> redirect to JomSocial reg
	 * 		-- NO  -> send user to pType selection page
	 * */
	//BLANK means task should be empty
	function event_com_community_register_blank()
	{
		return $this->integrateRegistrationWithPType();
	}
	
	
	function event_com_community_profile_blank()
	{
		$isFromFacebook = $this->getDataInSession('FROM_FACEBOOK',false);
		$aec_integrate  = XiPTLibraryUtils::getParams('aec_integrate','com_xipt', 0);
		if($isFromFacebook)		
			$this->resetDataInSession('FROM_FACEBOOK');	
	
		if($isFromFacebook == true && $aec_integrate == true) {
			$link = JRoute::_('index.php?option=com_acctexp&task=subscribe',false);
			$this->mainframe->redirect($link);
		}
	}
	
	
	function event_com_user_register_blank()
	{
	    return $this->integrateRegistrationWithPType();
	}
	
	/*Get decision to show ptype on registration session or not */
	function integrateRegistrationWithPType()
	{
		//set up return url to return user to registration page again
	    XiPTLibraryUtils::setReturnURL();
	    XiPTLibraryAEC::getProfiletypeInfoFromAEC() ;

		$show_ptype_during_reg = XiPTLibraryUtils::getParams('show_ptype_during_reg','com_xipt', 0);
		$selectedProfiletypeID = $this->isPTypeExistInSession();

		if($show_ptype_during_reg){

			$link = "index.php?option=com_xipt&view=registration";
								
			$menu = &JSite::getMenu(); 
			$itemid = $menu->getItems('link', $link);

			$itemInfo = '';
			if(!empty($itemid))
				$itemInfo .= "&Itemid=".$itemid[0]->id;
								
			// pType not selected : send to select profiletype
			if(!$selectedProfiletypeID){
				$this->mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=registration".$itemInfo,false));
				return;
			}


			$aecExists = XiPTLibraryAEC::_checkAECExistance();
			$integrateAEC   = XiPTLibraryUtils::getParams('aec_integrate','com_xipt',0);

			// pType already selected
			if($integrateAEC && $aecExists)
			{
			    $url = JRoute::_('index.php?option=com_acctexp&task=subscribe',false);
			    $msg = XiPTLibraryAEC::getAecMessage();
			}
			else
			{
			    $url = JRoute::_('index.php?option=com_xipt&view=registration&ptypeid='.$selectedProfiletypeID.$itemInfo,false);
			    $selectedpTypeName = XiPTLibraryProfiletypes::getProfiletypeName($selectedProfiletypeID);
			    $msg = sprintf(JText::_('CURRENT PTYPE AND CHANGE PTYPE OPTION'),$selectedpTypeName);
			}

			$link = '<a id="xipt_back_link" href='.$url.'>'. JText::_("CLICK HERE").'</a>';
			$this->mainframe->enqueueMessage($msg.' '.$link);
			return;
		}

		// if pType is not set, collect default pType
		// set it in session
		if(!$selectedProfiletypeID) {
			$pType = $this->getRegistrationPType();
			$this->setDataInSession('SELECTED_PROFILETYPE_ID',$pType);
			return;
		}

		return;
	}
		
	/* get the plan id when the direct link of AEC are used */
	function event_com_acctexp_blank_subscribe()
	{
		$mySess =& JFactory::getSession();
		$usage  =  JRequest::getVar( 'usage', '0', 'REQUEST');
		$mySess->set('AEC_REG_PLANID',$usage, 'XIPT');			
	}

	// we are on xipt registration page
	function event_com_xipt_registration_blank()
	{
	    global $mainframe;
	    $integrateAEC   = XiPTLibraryUtils::getParams('aec_integrate','com_xipt');
	    //$forcePtypePage = XiPTLibraryUtils::getParams('aec_force_ptype_page','com_xipt');

	    // if we do not want to integrate AEC then simply return
	    if(!$integrateAEC)
	        return;

	    // aec not installed.
	    $aecExists = XiPTLibraryAEC::_checkAECExistance();
	    if(!$aecExists)
	        return;

	    // find selected profiletype from AEC
	    $aecData = XiPTLibraryAEC::getProfiletypeInfoFromAEC() ;

	    // as user want to integrate the AEC so a plan must be selected
        // send user to profiletype selection page
	    if($aecData['planSelected']==false)
	        $mainframe->redirect(JRoute::_('index.php?option=com_acctexp&task=subscribe',false),JText::_('PLEASE SELECT AEC PLAN, IT IS RQUIRED'));

	    // set selected profiletype in session
	    $this->mySess->set('SELECTED_PROFILETYPE_ID',$aecData['profiletype'], 'XIPT');
	    $mainframe->redirect(XiPTLibraryUtils::getReturnURL());
	}

	/**
	 * Filter the fields, which are allowed to user.
	 * @param $userid
	 * @param $fields
	 * @return true
	 */
	function isAdvanceSearch()
	{
		$view   = JRequest::getVar('view','','GET');
		$task   = JRequest::getVar('task','','GET');
		$option = JRequest::getVar('option','','GET');
		if($option === 'com_community' && $view === 'search' && $task === 'advancesearch')
			return true;

		return false;
	}
	
	function onProfileLoad(&$userid, &$fields, $from)
	{
	    if($this->isAdvanceSearch() === true)
	    	return true;
		XiPTLibraryProfiletypes::filterCommunityFields($userid, $fields, $from);
	    return true;
	}

	function performACLCheck(&$ajax, &$callArray, &$args)
	{
	    return XiPTLibraryAcl::performACLCheck($ajax, $callArray, $args);
	}
	
	function onAfterConfigSave()
	{
		XiPTHelperUnhook::store_globalconfiguration();
	}

}

