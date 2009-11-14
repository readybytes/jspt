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
	private $params;
	private $mainframe;

	
	function __construct()
	{
		global $mainframe;
		$this->mainframe =& $mainframe;
		 
		$this->mySess = & JFactory::getSession();
		$this->params = JComponentHelper::getParams('com_xipt');
	}
	
	//if value exist in session then return ptype else return false
	function isPTypeExistInSession()
	{
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
		XiPTLibraryAcl::performACLCheck(true, $callArray, $args);
		
		// If we come here means ACL Check was passed
		$controller	=	$callArray[0];
		$function	=	$callArray[1];
		if($controller	==	'register')
		{
			switch($function)
			{
				case 'ajaxCheckEmail' 	 :
				case 'ajaxCheckUserName' :
					return XiPTLibraryUtils::$function($args,$response);
			}
		}
		
		// we do not want to interfere, go ahead JomSocial
		return true;
	}
	
	
	/**
	 * This function will store user's registration information
	 * in the tables, when Community User object is created
	 * @param $cuser
	 * @return true
	 */
	function onProfileCreate($cuser)
	{
		$userid	= $cuser->_userid;
		
		// find pType of user
		$profiletypeID = XiPTPluginHandler::getRegistrationPType();

		// need to set everything
		XiPTLibraryCore::setProfileDataForUserID($userid, $profiletypeID, 'ALL');
		
		//clean the session
		XiPTPluginHandler::cleanRegistrationSession();

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
	function onBeforeProfileUpdate($userId, &$fieldValueCodes)
	{
		// TODO : Check for both fields exist in array or not
		$profileTypeValue =& $fieldValueCodes[PROFILETYPE_CUSTOM_FIELD_CODE];
		$templateValue    =& $fieldValueCodes[TEMPLATE_CUSTOM_FIELD_CODE];

		// user is allowed or not.
        $allowToChangePType    = $this->params->get('allow_User_to_change_ptype_after_reg',0);
        $allowToChangeTemplate = $this->params->get('allow_templatechange','0');
        
        // not changing anything get data from table and set it
		if(0 == $allowToChangeTemplate){
		    $userid = JRequest::getVar('userid',0,'GET');
			$templateValue = XiPTLibraryProfiletypes::getUserData($userid,'TEMPLATE');
		}

		// not allowed to change profiletype, get data from table and set it
		if(0 == $allowToChangePType){
		    $userid = JRequest::getVar('userid',0,'GET');
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
	    //TODO : The event is missing from backend ????
	    // data was not saved, do nothing
	    if(!$saveSuccess)
	        return true;

	    $cuser        = CFactory::getUser($userid);
	    $profiletype  = $cuser->getInfo(PROFILETYPE_CUSTOM_FIELD_CODE);
	    $template     = $cuser->getInfo(TEMPLATE_CUSTOM_FIELD_CODE);

	    XiPTLibraryProfiletypes::saveXiPTUser($userid,$profiletype,$template);
	    return true;
	}
	
	/*
	 * This function require to protect deletion of
	 * default avatar of profiletype because JS
	 * delete non-default avatar when user change his avatar
	 * so in that case if that user has any ptype default avatar
	 * then our ptype avatar will be deleted.
	 */
	function onProfileAvatarUpdate($userid, &$old_avatar_path, $new_avatar_path)
	{
	    //TODO: check for a valid $userid
		
		//check if avatar is ptype default avatar
		if(XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($old_avatar_path,false)){
			$thumb = strstr('_thumb',$old_avatar_path);
			if ($thumb)
				$old_avatar_path = 'components/com_community/assets/default_thumb.jpg';
			else
				$old_avatar_path = 'components/com_community/assets/default.jpg';
		}

		return true;
	}
	
	
	function onAfterAppsLoad()
	{
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
		$show_ptype_during_reg = $this->params->get('show_ptype_during_reg', 0);
		$selectedProfiletypeID = $this->isPTypeExistInSession();
		
		if($show_ptype_during_reg){
			
			// pType not selected : send to select profiletype
			if(!$selectedProfiletypeID){
				$this->mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=registration",false));
				return;
			}
			
			// pType already selected
			$url = JRoute::_('index.php?option=com_xipt&view=registration&ptypeid='.$selectedProfiletypeID,false);
			$link = '<a href='.$url.'>'. JText::_("CLICK HERE").'</a>';
			
			//get profiletype name from ptype id
			$selectedpTypeName = XiPTLibraryProfiletypes::getProfiletypeName($selectedProfiletypeID);
			$this->mainframe->enqueueMessage(sprintf(JText::_('CURRENT PTYPE AND CHANGE PTYPE OPTION'),$selectedpTypeName,$link));
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
	
	
	/**
	 * Filter the fields, which are allowed to user.
	 * @param $userid
	 * @param $fields
	 * @return true
	 */
	function onProfileLoad(&$userid, &$fields, $from)
	{
	    XiPTLibraryProfiletypes::filterCommunityFields($userid, $fields, $from);
	    return true;
	}
	
}
