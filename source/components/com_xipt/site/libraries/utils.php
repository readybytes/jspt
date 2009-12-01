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
	    require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'helpers'.DS.'owner.php';
		return isCommunityAdmin($id);
	}
	
	/*function checkEditAccessRight($myId, $calleId)
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
	}*/
	
	
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
				if( $file != '.' && $file != '..' && $file != '.svn' && $file != 'index.html')
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
	
	
	function getWatermark($userid)
	{
		$ptype = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
		//CODREV : find what should be default watermark
		//ptypename , watermark image or avatar
		//generate image with name if name is enable
		$watermarkInfo = XiPTLibraryProfiletypes::getProfiletypeData($ptype,'watermark');
		if(!$watermarkInfo)
			$watermarkInfo = XiPTLibraryProfiletypes::getProfiletypeData($ptype,'avatar');
		
		return $watermarkInfo;
	}
	
	
	function addWatermarkOnAvatar($userid,&$avatar,$waterMark,$what)
	{
		// Load image helper library as it is needed.
		CFactory::load( 'helpers' , 'image' );
		
		if(XiPTLibraryProfiletypes::isDefaultAvatarOfProfileType($avatar,true))
			return;
		
		if($what == 'thumb')
			$waterMark = self::getThumbAvatarFromFull($waterMark);
		
		$extension			= JString::substr( $avatar , JString::strrpos( $avatar , '.' ) );
		
		$type				= 'image/jpg';
			
		if( $extension == '.png' )
		{
			$type			= 'image/png';
		}
		
		if( $extension == '.gif' )
		{
			$type	= 'image/gif';
		}

		if($what == 'avatar'){
			$watermarkWidth = WATERMARK_HEIGHT;
			$watermarkHeight = WATERMARK_WIDTH;
		}
		
		if($what == 'thumb'){
			$watermarkWidth = WATERMARK_HEIGHT_THUMB;
			$watermarkHeight = WATERMARK_WIDTH_THUMB;
		}
		//list( $watermarkWidth , $watermarkHeight ) = getimagesize( $waterMark );
		list( $imageWidth , $imageHeight ) = getimagesize( $avatar );
		list( $thumbWidth , $thumbHeight ) = getimagesize( $avatar );
		
		cImageAddWaterMark( $avatar , $avatar , $type , $waterMark , ( $imageWidth - $watermarkWidth ), ( $imageHeight - $watermarkHeight) );
		
		//cImageAddWaterMark( $storageThumbnail , $storageThumbnail , $type , FACEBOOK_FAVICON , ( $thumbWidth - $watermarkWidth ), ( $thumbHeight - $watermarkHeight) );
	}
	
	
	//get params data from xipt component or any
	function getParams($paramName,$comName)
	{
		$params = JComponentHelper::getParams($comName);
		$result = $params->get($paramName);
		return $result;
	}
	
	
	function getCurrentURL()
	{
		// TO DO : Get url
		$url = JFactory::getURI()->toString( array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment'));
		return $url;
	}

	//CODREV TODOXI : use it everywhere. 
	function getReturnURL()
	{
	    $mySess    = JFactory::getSession();
	    $retURL     = $mySess->get('RETURL', 'XIPT_NOT_DEFINED', 'XIPT');
	    $defaultURL	= JRoute::_('index.php?option=com_community&view=register',false);
	    
		if($retURL == 'XIPT_NOT_DEFINED')
		    $redirectURL = $defaultURL;
		else
			$redirectURL = base64_decode($retURL);

		if($redirectURL == self::getCurrentURL())
		    assert(0);
		    
		return $redirectURL;
	}
	
	function setReturnURL()
	{
	    
	    $mySess    = JFactory::getSession();
	    if($mySess->get('RETURL',false ,'XIPT'))
	        return;
	    
	    $mySess->set('RETURL', base64_encode(self::getCurrentURL()), 'XIPT');
	    return;
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