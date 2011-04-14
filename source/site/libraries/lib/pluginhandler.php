<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 */

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// include files, as we are here from plugin
// so files might not be included for non-component events
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php';

//@TODO: Write language file
//@TODO : check ptypeid in session in registerProfile fn also

//This class should be only access from it's static object.
class XiptLibPluginhandler
{
	public $mySess ;
	public $app;


	function __construct()
	{
		$this->app = JFactory::getApplication();
		$this->mySess    =  JFactory::getSession();
	}

	//if value exist in session then return ptype else return false
	function isPTypeExistInSession()
	{
		$aecExists 		= XiptLibAec::isAecExists();
		$integrateAEC   = XiptFactory::getSettings('aec_integrate',0);
		if($aecExists && $integrateAEC)
		{
			$data  = XiptLibAec::getProfiletypeInfoFromAEC() ;
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
		$defaultProfiletypeID = XiptLibProfiletypes::getDefaultProfiletype();

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

	function onAjaxCall(&$func, &$args , &$response)
	{
		$callArray	= explode(',', $func);

		//perform Access checks
		$ajax = true;
		XiptAclHelper::performACLCheck($ajax, $callArray, $args);

		// If we come here means ACL Check was passed
		$controller	=	$callArray[0];
		$function	=	$callArray[1];
	
		switch($controller.'_'.$function)
		{
			//before creating new account, validate email and username
			case 'connect_ajaxCreateNewAccount' :
				return XiptHelperRegistration::ajaxCreateNewAccountFacebook($args,$response);

			case 'connect_ajaxCheckEmail' 	 :
				return XiptHelperRegistration::ajaxCheckEmailDuringFacebook($args,$response);

			case 'connect_ajaxCheckUsername' :
				return XiptHelperRegistration::ajaxCheckUsernameDuringFacebook($args,$response);
			
			case 'connect_ajaxShowNewUserForm' :
				return XiptHelperRegistration::ajaxShowNewUserForm($args,$response);
			
			case 'connect_ajaxUpdate' :
				return XiptHelperRegistration::ajaxUpdate($args,$response);

			// when controller == register
			case 'register_ajaxCheckEmail' 	 :

			case 'register_ajaxCheckUserName' :
					return XiptHelperRegistration::$function($args,$response);
					
			//when controller == apps
			case 'apps_ajaxAddApp' : 
			case 'apps_ajaxAdd' : 
					$my	= JFactory::getUser();

				    //XITODO : Remove it and add assert
				    if(0 == $my->id) return true;

		    		$profiletype = XiptLibProfiletypes::getUserData($my->id,'PROFILETYPE');
		    		return XiptLibApps::filterAjaxAddApps($args[0],$profiletype,$response);
		    		
			case 'profile_ajaxConfirmRemoveAvatar':
			//case 'profile_ajaxConfirmRemovePicture': 
			case 'profile_ajaxRemovePicture' : // This case use for Admin panel
						return XiptLibAvatar::removeAvatar($args, $response);
				
			default :
				// 	we do not want to interfere, go ahead JomSocial
					return true;
		}
	}
	
	/*Get decision to show ptype on registration session or not */
	function integrateRegistrationWithPType()
	{
	    XiptLibAec::getProfiletypeInfoFromAEC() ;

		$show_ptype_during_reg = XiptFactory::getSettings('show_ptype_during_reg', 0);
		$selectedProfiletypeID = $this->isPTypeExistInSession();

		if($show_ptype_during_reg){
			$link 	= "index.php?option=com_xipt&view=registration";								
			// pType not selected : send to select profiletype
				if(!$selectedProfiletypeID){
				$this->app->redirect(XiptRoute::_("index.php?option=com_xipt&view=registration",false));
				return;
			}


			$aecExists 		= XiptLibAec::isAecExists();
			$integrateAEC   = XiptFactory::getSettings('aec_integrate',0);

			// pType already selected
			if($integrateAEC && $aecExists)
			{
			    $url = XiptRoute::_('index.php?option=com_acctexp&task=subscribe',false);
			    $msg = XiptLibAec::getAecMessage();
			}
			else
			{
			    $url               = XiptRoute::_('index.php?option=com_xipt&view=registration&ptypeid='.$selectedProfiletypeID.'&reset=true',false);
			    $selectedpTypeName = XiptLibProfiletypes::getProfiletypeName($selectedProfiletypeID);
			    $msg 			   = sprintf(XiptText::_('CURRENT_PTYPE_AND_CHANGE_PTYPE_OPTION'),$selectedpTypeName);
			}

			$link = '<a id="xipt_back_link" href='.$url.'>'. XiptText::_("CLICK_HERE").'</a>';
			$this->app->enqueueMessage($msg.' '.$link);
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
		$none 			 			 = false;
		$args['triggerForEvents']    = 'onprofileload';
		$args['field']   			 =  &$fields      ;
		XiptAclHelper::performACLCheck($none,$none, $args);

		//do not filter fields in  advanced search if user do not want to restrict
		// field according to profiletype
		
		$restrict_advancesearchfield = XiptFactory::getSettings('restrict_advancesearchfield', 0);
		$view	= JRequest::getVar('view','');
		$task 	= JRequest::getVar('task','');
		
		if(!$restrict_advancesearchfield)
		 {
			if($view === 'search' && $task === 'advancesearch')
				return true;
		 }
	    XiptLibProfiletypes::filterCommunityFields($userid, $fields, $from);
	    return true;
	}
	
	function checkSetupRequired()
	{
		//XITODO : check is setup required 
		$mysess =  JFactory::getSession();
		if($mysess->has('requireSetupCleanUp') == true && $mysess->get('requireSetupCleanUp',false) == true)
 				return true;

//		//get all files required for setup
//		$setupNames = XiptSetupHelper::getOrder();
//		
//		foreach($setupNames as $setup)
//		{
//			//get object of class
//			$setupObject = XiptFactory::getSetupRule($setup);
//			
//			$setupObject->isRequired();
//		}	 

		$mysess->get('requireSetupCleanUp',false);
		return false;
	}
}

