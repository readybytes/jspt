<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperRegistration
{
	public static function ajaxUpdate(&$args, &$response)
	{
		$mySess 	= JFactory::getSession();
		$mySess->clear('SELECTED_PROFILETYPE_ID','XIPT');
		return true;
	}
	
	public static function ajaxShowNewUserForm(&$args, &$response)
	{
		$mySess 	= JFactory::getSession();
		
		//Set facebook variable in session so we can redirect user
		//to plan selection page after login
		//XITODO : we will remove this when aec support fbc
		
		$aecExists = XiptLibAec::isAecExists();
		if($aecExists)
			$mySess->set('FROM_FACEBOOK',true, 'XIPT');
		
		/*if ptype is not required during registration then return */
		if(!XiptFactory::getSettings('show_ptype_during_reg', 0))		
			return true;

		//if aec is integrate with ptype then we don't want to display
		//ptype selection page during facebook integration so return
		// pType already selected
		if($aecExists && XiptFactory::getSettings('subscription_integrate',0))
			return true;
			
		/*check if ptype exist in session , 
		 * if true means we have already gone through ptype selection process
		 * no need to process again , return
		 */
		if($mySess->get('SELECTED_PROFILETYPE_ID',0,'XIPT'))
			return true;

		/*if not any above process fullfill the requirement then 
		 * we need to display ptype selection page
		 */
		$html = '';
		if($args && count($args)) {
			$selectedProfiletypeID = $args[0];
			// validate values
			if(XiptLibProfiletypes::validateProfiletype($selectedProfiletypeID)) {
				$mySess->set('SELECTED_PROFILETYPE_ID',$selectedProfiletypeID, 'XIPT');
				return true;
			}
			else
				$html .= XiptText::_('PLEASE_ENTER_VALID_PROFILETYPE');
		}
		
		return self::getPtypeDisplayPageForFacebook($response,$html);		
	}
	
	
	public static function getPtypeDisplayPageForFacebook(&$response,$addhtml)
	{
		//XITODO : trigger an API Event to add something to templates, or modify $profiletypes array
		// e.g. : I want to patch description. with some extra information
		$filter 				= 	array('published'=>1,'visible'=>1);
	    $allProfileTypes 		= 	XiptLibProfiletypes::getProfiletypeArray($filter);
	    $defaultPType 			= 	XiptLibProfiletypes::getDefaultProfiletype();
		$selectedPT                =     $defaultPType;
		
		$params = XiptFactory::getSettings('', 0);
		$showAsRadio = $params->getValue('jspt_fb_show_radio',null,false);
		
		ob_start();
		include(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'views'.DS.'registration'.DS.'tmpl'.DS.'facebook.php');
		$contents = ob_get_contents();
		ob_end_clean();
		
		$html  = '';
		$html .= $addhtml;
		$html .= $contents;
		
		$buttons = '';
		
		if($showAsRadio) {
			$response->addScriptCall('cWindowResize' , PTYPE_POPUP_WINDOW_HEIGHT_RADIO , PTYPE_POPUP_WINDOW_WIDTH_RADIO);
			$buttons	= '<input type="button" value="' . XiptText::_('NEXT') . '" class="button" onclick="cWindowShow(jax.call(\'community\',\'connect,ajaxShowNewUserForm\', + joms.jQuery(\'[name=profiletypes]:checked\').val()), \'\', 450, 200); return false;" />';
		}
		else{
			$response->addScriptCall('cWindowResize' ,PTYPE_POPUP_WINDOW_HEIGHT_SELECT, PTYPE_POPUP_WINDOW_WIDTH_SELECT);
			$buttons	= '<input type="button" value="' . XiptText::_('NEXT') . '" class="button" onclick="cWindowShow(jax.call(\'community\',\'connect,ajaxShowNewUserForm\', + joms.jQuery(\'#profiletypes\').val()), \'\', 450, 200); return false;" />';
		}
		$response->addScriptCall('joms.jQuery("#cwin_logo").html("' . XiptText::_ ( 'CHOOSE_PROFILE_TYPE' ) . '");');
		$response->addAssign('cWindowContent' , 'innerHTML' , $html);
		$response->addScriptCall('cWindowActions', $buttons);
		$response->sendResponse();
		
	}
	
	public static function ajaxCreateNewAccountFacebook(&$args, &$response)
	{
		//Added Profiletype Specific support
		$pluginHandler = new XiptLibPluginhandler();
		$ptype  = $pluginHandler->isPTypeExistInSession();		
		
		if(!$ptype){
			
			//when no profiletype selected select default
			$ptype = XiptLibProfiletypes::getDefaultProfiletype();
			
//			XiptError::assert($ptype, XiptText::_('PROFILE TYPE IS NOT SELECTED'), XiptError::WARNING);
//			return false;
		}
		
		// as per JomSocial code
		$username = $args[1];
		$email    = $args[2];
			
		$isValidUsername = XiptHelperRegistration::checkIfUsernameAllowed($username, $ptype);
		$isValidEmail	 = XiptHelperRegistration::checkIfEmailAllowed($email, $ptype);
		if($isValidUsername && $isValidEmail)  
			return true;
		
		ob_start();
		include(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'views'.DS.'registration'.DS.'tmpl'.DS.'facebook_error.php');
		$contents = ob_get_contents();
		ob_end_clean();
		
		$html  = '';
		$html .= $contents;
		
		$buttons = '';		
		
		$response->addScriptCall('cWindowResize' , PTYPE_POPUP_WINDOW_HEIGHT_RADIO , PTYPE_POPUP_WINDOW_WIDTH_RADIO);
		$response->addScriptCall('joms.jQuery("#cwin_logo").html("' . XiptText::_('REGISTRATION_VALIDATION') . '");');
		$buttons	= '<input type="button" value="' . XiptText::_('BACK') . '" class="button" onclick="cWindowShow(jax.call(\'community\',\'connect,ajaxShowNewUserForm\', + jQuery(\'[name=profiletypes]:checked\').val()), \'\', 450, 200); return false;" />';
		$response->addAssign('cWindowContent' , 'innerHTML' , $html);
		$response->addScriptCall('cWindowActions', $buttons);
		$response->sendResponse();
	}
	
	public static function ajaxCheckEmailDuringFacebook(&$args, &$response)
	{
		//Added Profiletype Specific support
		$pluginHandler = new XiptLibPluginhandler();
		$ptype  = $pluginHandler->isPTypeExistInSession();		
		
		if(!$ptype){
			
			//when no profiletype selected select default
			$ptype = XiptLibProfiletypes::getDefaultProfiletype();
			//XiptError::assert($ptype, XiptText::_('PROFILE TYPE IS NOT SELECTED'), XiptError::WARNING);
			//return false;
		}
		
		// as per JomSocial code
		$email = $args[0];
		if(XiptHelperRegistration::checkIfEmailAllowed($email, $ptype))
			return true;

		// invalid emails
		$msg = XiptText::_('XIPT_EMAIL_NOT_ALLOWED');
		$response->addScriptCall('joms.jQuery("#newemail").addClass("invalid");');
		$response->addScriptCall('joms.jQuery("#error-newemail").show();');
		$response->addScriptCall('joms.jQuery("#error-newemail").html("' . $msg . '");');
		//$response->addScriptCall('false;');
		return false;
	}
	
	public static function ajaxCheckUsernameDuringFacebook(&$args, &$response)
	{
		$pluginHandler = new XiptLibPluginhandler();
		$ptype  = $pluginHandler->isPTypeExistInSession();
		
		if(!$ptype){
			//when no profiletype selected select default
			$ptype = XiptLibProfiletypes::getDefaultProfiletype();
			//XiptError::assert($ptype, XiptText::_('PROFILE TYPE IS NOT SELECTED'), XiptError::WARNING);
			//return false;
		}
			
		// as per JomSocial code
		$email = $args[0];
		if(XiptHelperRegistration::checkIfUsernameAllowed($email, $ptype))
			return true;

		// invalid emails
		$msg = XiptText::_('XIPT_USERNAME_NOT_ALLOWED');
		$response->addScriptCall('joms.jQuery("#newusername").addClass("invalid");');
		$response->addScriptCall('joms.jQuery("#error-newusername").show();');
		$response->addScriptCall('joms.jQuery("#error-newusername").html("' . $msg . '");');
		//$response->addScriptCall('false;');
		return false;
	}
	
	
	public static function ajaxCheckEmail(&$args, &$response)
	{
		$pluginHandler = new XiptLibPluginhandler();
		$ptype  = $pluginHandler->isPTypeExistInSession();
		
		if(!$ptype){
			$ptype = XiptLibProfiletypes::getDefaultProfiletype();
//			XiptError::assert($ptype, XiptText::_('PROFILE_TYPE_IS_NOT_SELECTED'), XiptError::WARNING);
//			return false;
		}
		
		// as per JomSocial code
		$email = $args[0];
		if(XiptHelperRegistration::checkIfEmailAllowed($email,$ptype))
			return true;

		// invalid emails
		$msg = XiptText::_('XIPT_EMAIL_NOT_ALLOWED');
		$response->addScriptCall('joms.jQuery("#jsemail").addClass("invalid");');
		$response->addScriptCall('joms.jQuery("#errjsemailmsg").show();');
		$response->addScriptCall('joms.jQuery("#errjsemailmsg").html("<br/>'.$msg.'");');
		$response->addScriptCall('joms.jQuery("#emailpass").val("N");');
		$response->addScriptCall('false;');
		return false;
	}

	public static function ajaxCheckUserName(&$args, &$response)
	{
		$pluginHandler = new XiptLibPluginhandler();
		$ptype  = $pluginHandler->isPTypeExistInSession();
				
		if(!$ptype){
			$ptype = XiptLibProfiletypes::getDefaultProfiletype();
//			XiptError::assert($ptype, XiptText::_('PROFILE_TYPE_IS_NOT_SELECTED'), XiptError::WARNING);
//			return false;
		}		
		// as per JomSocial code
		$uname = $args[0];
		if(XiptHelperRegistration::checkIfUsernameAllowed($uname, $ptype))
			return true;

		// username not allowed
		$msg = XiptText::_('XIPT_USERNAME_NOT_ALLOWED');
		$response->addScriptCall('joms.jQuery("#jsusername").addClass("invalid");');
		$response->addScriptCall('joms.jQuery("#errjsusernamemsg").show();');
		$response->addScriptCall('joms.jQuery("#errjsusernamemsg").html("<br/>'.$msg.'");');
		$response->addScriptCall('joms.jQuery("#usernamepass").val("N");');
		$response->addScriptCall('false;');
		return false;
	}
	
	public static function getPTPrivacyValue($privacy)
	{
			$value = PRIVACY_PUBLIC;
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
					XiptError::assert(0);
			}
		return $value;
	}
    
	public static function checkIfEmailAllowed($testEmail, $ptype)
	{
		//jspt_prevent_username
		$config = XiptLibProfiletypes::getParams($ptype, 'config');
	
		if(!$config['jspt_restrict_reg_check'])
			return true;
			
		$invalidemails = explode(';', $config['jspt_prevent_email']);		
				
		if(!empty($invalidemails) && !empty($invalidemails[0]))
		{
			foreach($invalidemails as $invalidemail)
			{
				if(empty($invalidemail))
				    continue;
				$email	= preg_quote(trim($invalidemail), '/');
				$email	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $email);
				$regex	= "/^(.*$email)$/i";
			
				if(preg_match($regex, JString::trim($testEmail)))
					return false;
			}
		}

		// if allowed email
		$validemails		= explode(';',$config['jspt_allowed_email']);
		if(!empty($validemails) && !empty($validemails[0]))
		{
			foreach($validemails as $validemail)
			{
				if(empty($validemail))
				    continue;    
				$email	= preg_quote(trim($validemail), '/');
				$email	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $email);
				$regex	= "/^(.*$email)$/i";
			
				if(preg_match($regex, JString::trim($testEmail)))
					return true;
			}
			// not in allowed list, must return false
			return false;
		}
		
		// none of condition stopped, allow email
		return true;
	}
	
	public static function checkIfUsernameAllowed($testUsername, $ptype)
	{
		//jspt_prevent_username
		$config = XiptLibProfiletypes::getParams($ptype, 'config');
	
		if(!$config['jspt_restrict_reg_check'])
			return true;
			
		$invalidUsernames = explode(';', $config['jspt_prevent_username']);
		
		if(empty($invalidUsernames) || empty($invalidUsernames[0]))
			return true;
		
		foreach($invalidUsernames as $invalidUsername){
			$username	= preg_quote(trim($invalidUsername), '#');
			$username	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $username);
			$regex		= "/$username/i"; 
			
			if(empty($invalidUsername))
				continue;   
			
			if(preg_match($regex, JString::trim($testUsername)))
				return false;
		}
		
		//passed through all rules, allow it
		return true;
	}
}
