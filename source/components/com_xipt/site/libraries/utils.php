<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTLibraryUtils
{
	function ajaxCheckEmail(&$args, &$response)
	{
		// as per JomSocial code
		$email = $args;
		if(XiPTLibraryUtils::checkIfEmailAllowed($email))
			return true;

		// invalid emails
		$msg = JText::_('XIPT EMAIL NOT ALLOWED');
		$response->addScriptCall('jQuery("#jsemail").addClass("invalid");');
		$response->addScriptCall('jQuery("#errjsemailmsg").show();');
		$response->addScriptCall('jQuery("#errjsemailmsg").html("<br/>'.$msg.'");');
		$response->addScriptCall('jQuery("#emailpass").val("N");');
		$response->addScriptCall('false;');
		return false;
	}

	function ajaxCheckUserName(&$args, &$response)
	{
		// as per JomSocial code
		$uname = $args;
		if(XiPTLibraryUtils::checkIfUsernameAllowed($uname))
			return true;

		// username not allowed
		$msg = JText::_('XIPT USERNAME NOT ALLOWED');
		$response->addScriptCall('jQuery("#jsusername").addClass("invalid");');
		$response->addScriptCall('jQuery("#errjsusernamemsg").show();');
		$response->addScriptCall('jQuery("#errjsusernamemsg").html("<br/>'.$msg.'");');
		$response->addScriptCall('jQuery("#usernamepass").val("N");');
		$response->addScriptCall('false;');
		return false;
	}
	
	function checkIfEmailAllowed($testEmail)
	{
		$config = JComponentHelper::getParams('com_xipt');
		
		$jspt_restrict_reg_check = $config->get('jspt_restrict_reg_check',false);
		if($jspt_restrict_reg_check == false)
			return true;
			
		$jspt_allowed_email = $config->get('jspt_allowed_email');
		$jspt_prevent_email = $config->get('jspt_prevent_email');
		
		// is the email blocked
		$invalidemails		= explode(';',$jspt_prevent_email);
		
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
			// not in allowed list, must return false
			return false;
		}
		
		// none of condition stopped, allow email
		return true;
	}
	
	function checkIfUsernameAllowed($testUsername)
	{
		//jspt_prevent_username
		$config = JComponentHelper::getParams('com_xipt');
		
		$jspt_restrict_reg_check = $config->get('jspt_restrict_reg_check',false);
		if($jspt_restrict_reg_check == false)
			return true;
			
		$jspt_prevent_username = $config->get('jspt_prevent_username');
		
		// is the email blocked
		$invalidUsernames		= explode(';',$jspt_prevent_username);
		if($invalidUsernames!='')
			foreach($invalidUsernames as $invalidUsername)
			{
				$username	= preg_quote(trim($invalidUsername), '#');
				$username	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $username);
				$regex	= "#^(?:$username)$#i";
			
				if(preg_match($regex, $testUsername))
					return false;
			}
		
		//passed through all rules, allow it
		return true;
	}
	
	
	
    function isAdmin($id, $refID=0)
	{
		//TODO get it from community
		return false;
	}
	
	function checkEditAccessRight($myId, $calleId)
	{
		// Always I can edit my own profile
		if($myId ==  $calleId)
			return true;
			
		// are u superadmin or admin,
		if(XiPTLibraryUtils::isAdmin($myId, $calleId))
			return true;
    
		return false;
	}
	
	function canEditMe($myId, $calleId)
	{
		return XiPTLibraryUtils::checkEditAccessRight($myId, $calleId);
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
	
	
	function getCurrentURL()
	{
		// TO DO : Get url
		$url = JFactory::getURI()->toString( array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment'));
		return base64_encode($url);
	}
	
/* =====   Currently Not Required  ====
 *
 * function getEditInfo()
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
	     $editInfo->canEdit = XiPTLibraryCore::checkEditAccessRight($editor->id , $editDataOf );
      
      return $editInfo;
  }*/
}