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
	
	
	
    function isAdmin($id)
	{
		$my	=& CFactory::getUser($id);		
		return ( $my->usertype == 'Super Administrator');
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
		
		$handle = @opendir($path);
		if( $handle )
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
	
	function getImageType($imagePath)
	{
		$extension	= JFile::getExt($imagePath);	
		switch($extension)
		{
			case 'png':
				$type	= 'image/png';
				break;
			case 'gif':
				$type	= 'image/gif';
				break;
			case 'jpg':
			case 'jpeg':
			default :
				$type	= 'image/jpg';
		}
		return $type;
	}
	
	function addWatermarkOnAvatar($userid, &$image, $waterMark, $what)
	{
		// Load image helper library as it is needed.
		require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'helpers'.DS.'image.php';
		ini_set('gd.jpeg_ignore_warning', 1);
		
		if($what == 'thumb')
			$waterMark = self::getThumbAvatarFromFull($waterMark);
		
		$image = JPATH_ROOT. DS. $image;
		$waterMark= JPATH_ROOT. DS. $waterMark;
		
		$type = self::getImageType($image);
		$wType = self::getImageType($waterMark);

		if($wType == 'image/jpg')
		{
			global $mainframe;
			$mainframe->enqueueMessage("Watermark must be PNG or GIF image, no watermark applied");
			return false;
		}

		/*static $tmp = 0;
		if($tmp == 0)
		{
			$name = JPATH_ROOT.DS.$image.time();
			ob_start();
			echo phpinfo();
			$output = ob_get_contents();
			ob_end_clean();
			
			JFile::write($name, $output);
			$tmp++;
		}*/
		$imageInfo	= getimagesize($image);
		
		if($imageInfo ==false)
		{
			global $mainframe;
			$mainframe->enqueueMessage("Unable to open through getimage the file $image");
			return false;
		}
		
		$imageWidth = $imageInfo[0];//imagesx( $image );	
		$imageHeight= $imageInfo[1];// imagesy( $image );


		if($what == 'avatar'){
			$watermarkWidth  = WATERMARK_HEIGHT;
			$watermarkHeight = WATERMARK_WIDTH;
		}
		
		if($what == 'thumb'){
			$watermarkWidth  = WATERMARK_HEIGHT_THUMB;
			$watermarkHeight = WATERMARK_WIDTH_THUMB;
			
			//JSTODO : here we need to trick as per the JomSocial
			// we need to modify the code when things changes, currently 
			// the image informationfor thumbs does not come correctly
			$imageWidth = AVATAR_WIDTH_THUMB;
			$imageHeight = AVATAR_HEIGHT_THUMB;
		}
		
		
		//try jomSocial code
		return cImageAddWatermark($image, $image, $type, $waterMark, 
							($imageWidth - $watermarkWidth),
							($imageHeight - $watermarkHeight)
							);
		
		/*return self::XiImageAddWaterMark( $image, $waterMark,
							($imageWidth - $watermarkWidth),
							($imageHeight - $watermarkHeight)
						  );*/
	}
	
	/*
	 * 
	function XiImageAddWatermark( $imagePath, $watermarkPath , $positionX = 0 , $positionY = 0 )
	{
		assert(JFile::exists($imagePath) && JFile::exists($watermarkPath));
		
		//original image
		$destinationType = self::getImageType($imagePath);
		$imageImage		 = cImageOpen( $imagePath , $destinationType);
		$watermarkImage	 = cImageOpen( $watermarkPath , self::getImageType($watermarkPath));
		
		// Get overlay image width and hight
		$watermarkWidth		= imagesx( $watermarkImage );
		$watermarkHeight	= imagesy( $watermarkImage );
	
		// Combine background image and watermark into a single output image
		imagecopymerge( $imageImage , $watermarkImage , $positionX , $positionY , 0 , 0 , $watermarkWidth , $watermarkHeight , 100 );

		// Delete old image
		if(!JFile::delete( $imagePath ))
		{
			global $mainframe;
			$mainframe->enqueueMessage("Unable to delete the file $imagePath");
			
			imagedestroy( $imageImage );
			imagedestroy( $watermarkImage );
			
			return;
		}

		// Test if type is png
		if( $destinationType == 'image/png' || $destinationType == 'image/x-png' )
		{
			$output = imagepng( $imageImage, $imagePath  );
		}
		elseif ( $destinationType == 'image/gif')
		{
			$output = imagegif( $imageImage , $imagePath );
		}
		else
		{
			// We default to use jpeg
			$output =  imagejpeg($imageImage, $imagePath ,100);
		}
		
		// Free any memory from the existing image resources
		imagedestroy( $imageImage );
		imagedestroy( $watermarkImage );
		
		return $output;
	}
*/
	//get params data from xipt component or any
	function getParams($paramName='', $comName='com_xipt', $defaultValue=0)
	{
		$params = JComponentHelper::getParams($comName);
		
		if(!$params)
		{
		    JError::raiseWarning('XIPT_SYS_ERR','JSPT PARAMS ARE NULL');
		}
		
		if(empty($paramName))
			return $params;
			
		$result = $params->get($paramName,$defaultValue);
		
		return $result;
	}
	
	
	function getCurrentURL()
	{
		// TO DO : Get url
		$url = JFactory::getURI()->toString( array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment'));
		return $url;
	}

	//use it everywhere. 
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