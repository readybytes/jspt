<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTLibraryUtils
{
	
	function ajaxUpdate(&$args, &$response)
	{
		$mySess 	=& JFactory::getSession();
		$mySess->clear('SELECTED_PROFILETYPE_ID','XIPT');
		return true;
	}
	
	function ajaxShowNewUserForm(&$args, &$response)
	{
		$mySess 	=& JFactory::getSession();
		/*Set facebook variable is session so we can redirect user
			 * to plan selection page after login
			 * XITODO : we will remove this when aec support fbc
			 */	
		$aecExists = XiPTLibraryAEC::_checkAECExistance();
		if($aecExists)
			$mySess->set('FROM_FACEBOOK',true, 'XIPT');
		
		/*if ptype is not required during registration then return */
		$show_ptype_during_reg = XiPTLibraryUtils::getParams('show_ptype_during_reg','com_xipt', 0);
		
		if(!$show_ptype_during_reg)
			return true;

		/*if aec is integrate with ptype then we don't want to display
		 * ptype selection page during facebook integration so return
		 */
		$integrateAEC   = XiPTLibraryUtils::getParams('aec_integrate','com_xipt',0);

		// pType already selected
		if($integrateAEC && $aecExists)
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
			if(XiPTLibraryProfiletypes::validateProfiletype($selectedProfiletypeID)) {
				$mySess->set('SELECTED_PROFILETYPE_ID',$selectedProfiletypeID, 'XIPT');
				return true;
			}
			else
				$html .= JText::_('PLEASE ENTER VALID PROFILETYPE');
		}
		
		return self::getPtypeDisplayPageForFacebook($response,$html);		
	}
	
	
	function getPtypeDisplayPageForFacebook(&$response,$addhtml)
	{
		//XITODO : trigger an API Event to add something to templates, or modify $profiletypes array
		// e.g. : I want to patch description. with some extra information
		$filter = array('published'=>1,'visible'=>1);
	    $allProfileTypes = XiPTLibraryProfiletypes::getProfiletypeArray($filter);
	    $defaultPType = XiPTLibraryProfiletypes::getDefaultProfiletype();
		$selectedProfileTypeID = $defaultPType;
		
		$params = XiPTLibraryUtils::getParams('','com_xipt', 0);
		$showAsRadio = $params->get('jspt_fb_show_radio',false);
		
		ob_start();
		include(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'views'.DS.'registration'.DS.'tmpl'.DS.'facebook.php');
		$contents = ob_get_contents();
		ob_end_clean();
		
		$html = '';
		$html .= $addhtml;
		$html .= $contents;
		
		$buttons = '';
		
		if($showAsRadio) {
			$response->addScriptCall('cWindowResize' , PTYPE_POPUP_WINDOW_HEIGHT_RADIO , PTYPE_POPUP_WINDOW_WIDTH_RADIO);
			$buttons	= '<input type="button" value="' . JText::_('NEXT') . '" class="button" onclick="cWindowShow(jax.call(\'community\',\'connect,ajaxShowNewUserForm\', + jQuery(\'[name=profiletypes]:checked\').val()), \'\', 450, 200); return false;" />';
		}
		else{
			$response->addScriptCall('cWindowResize' ,PTYPE_POPUP_WINDOW_HEIGHT_SELECT, PTYPE_POPUP_WINDOW_WIDTH_SELECT);
			$buttons	= '<input type="button" value="' . JText::_('NEXT') . '" class="button" onclick="cWindowShow(jax.call(\'community\',\'connect,ajaxShowNewUserForm\', + jQuery(\'#profiletypes\').val()), \'\', 450, 200); return false;" />';
		}
		$response->addAssign('cWindowContent' , 'innerHTML' , $html);
		$response->addScriptCall('cWindowActions', $buttons);
		$response->sendResponse();
		
	}
	
	function ajaxCheckEmailDuringFacebook(&$args, &$response)
	{
		// as per JomSocial code
		$email = $args[0];
		if(XiPTLibraryUtils::checkIfEmailAllowed($email))
			return true;

		// invalid emails
		$msg = JText::_('XIPT EMAIL NOT ALLOWED');
		$response->addScriptCall('jQuery("#newemail").addClass("invalid");');
		$response->addScriptCall('jQuery("#error-newemail").show();');
		$response->addScriptCall('jQuery("#error-newemail").html("' . $msg . '");');
		//$response->addScriptCall('false;');
		return false;
	}
	
	function ajaxCheckUsernameDuringFacebook(&$args, &$response)
	{
		// as per JomSocial code
		$email = $args[0];
		if(XiPTLibraryUtils::checkIfUsernameAllowed($email))
			return true;

		// invalid emails
		$msg = JText::_('XIPT USERNAME NOT ALLOWED');
		$response->addScriptCall('jQuery("#newusername").addClass("invalid");');
		$response->addScriptCall('jQuery("#error-newusername").show();');
		$response->addScriptCall('jQuery("#error-newusername").html("' . $msg . '");');
		//$response->addScriptCall('false;');
		return false;
	}
	
	
	function ajaxCheckEmail(&$args, &$response)
	{
		// as per JomSocial code
		$email = $args[0];
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
		$uname = $args[0];
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
	
	/*XITODO : Add unit testing for this case */
	function checkIfEmailAllowed($testEmail)
	{
		$config = XiPTLibraryUtils::getParams('','com_xipt', 0);
		
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
				$email	= preg_quote(trim($invalidemail), '/');
				$email	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $email);
				$regex	= "/^(.*$email)$/i";
			
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
				$email	= preg_quote(trim($validemail), '/');
				$email	= str_replace(array("\r\<br /\>", '\*'), array('|', '.*'), $email);
				$regex	= "/^(.*$email)$/i";
			
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
		$config = XiPTLibraryUtils::getParams('','com_xipt', 0);
		
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
					XiPTLibraryUtils::XAssert(0);
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
		return $thumb;
	}
	
	
	function getWatermark($userid)
	{
		$ptype = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
		$watermarkInfo = XiPTLibraryProfiletypes::getProfiletypeData($ptype,'watermark');
		if(!$watermarkInfo)
			return false;
		
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
	
	//When we do not modify original image path, then we should not call it by reference.
	function addWatermarkOnAvatar($userid, $originalImage, $waterMark, $what)
	{		
		//IMP : do not modify original image.
		$image = JPATH_ROOT. DS. $originalImage;
		
		// Load image helper library as it is needed.
		require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'helpers'.DS.'image.php';
		//ini_set('gd.jpeg_ignore_warning', 1);
		
		$ptype = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
		$watermarkParams = XiPTLibraryProfiletypes::getParams($ptype,'watermarkparams');
		
		if($what == 'thumb')
			$waterMark = self::getThumbAvatarFromFull($waterMark);
				
		$waterMark= JPATH_ROOT. DS. $waterMark;
		
		$type = self::getImageType($image);
		$wType = self::getImageType($waterMark);

		if($wType == 'image/jpg')
		{
			global $mainframe;
			$mainframe->enqueueMessage("Watermark must be PNG or GIF image, no watermark applied");
			return false;
		}

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
			$watermarkWidth  = $watermarkParams->get('xiThumbWidth',0);
			$watermarkHeight = $watermarkParams->get('xiThumbHeight',0);
			
			//XITODO : here we need to trick as per the JomSocial
			// we need to modify the code when things changes, currently 
			// the image informationfor thumbs does not come correctly
			$imageWidth = AVATAR_WIDTH_THUMB;
			$imageHeight = AVATAR_HEIGHT_THUMB;
		}
		
		if(!JFile::exists($image) || !JFile::exists($waterMark))
			return false;
		
		
		// if warter marking is not enable for profile type then return
		
				
		/*First copy user old avatar b'coz we don't want to overwrite watermark */
		$avatarFileName = JFile::getName($originalImage);
		
		if(JFile::exists(USER_AVATAR_BACKUP.DS.$avatarFileName))
			JFile::copy(USER_AVATAR_BACKUP.DS.$avatarFileName,JPATH_ROOT.DS.$originalImage);

		// if watermarking is not enable for profile type then return
		if($watermarkParams->get('enableWaterMark',0) == false)
			return;
			
		$newimagepath = self::showWatermarkOverImage($image,$waterMark,'tmp',$watermarkParams->get('xiWatermarkPosition','br'));
				
		/*copy user original avatar at one place to remove destroy */
		jimport('joomla.filesystem.folder');
		//here check if folder exist or not. if not then create it.
		$avatarPath = USER_AVATAR_BACKUP;
		if(JFolder::exists($avatarPath)==false)
			JFolder::create($avatarPath);
		
		JFile::copy(JPATH_ROOT.DS.$originalImage,$avatarPath.DS.JFile::getName(JPATH_ROOT.DS.$originalImage));
		JFile::move(JPATH_ROOT.DS.$newimagepath,JPATH_ROOT.DS.$originalImage);
		return;
	}
	
	
	function showWatermarkOverImage( $imagePath, $watermarkPath ,$newImageName="tmp",$position='bl' )
	{
		XiPTLibraryUtils::XAssert(JFile::exists($imagePath) && JFile::exists($watermarkPath));
		
		//original image
		$destinationType = self::getImageType($imagePath);
		
		$watermarkType = self::getImageType($watermarkPath);
		// Load image helper library as it is needed.
		require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'helpers'.DS.'image.php';
		$watermarkImage	 = cImageOpen( $watermarkPath , $watermarkType);
		
		
		/*if(JFolder::exists(PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH)==false)
			JFolder::create(PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH);
			
		JFile::copy($imagePath,$newImagePath);*/
		$imageImage	 = cImageOpen( $imagePath , $destinationType);
		
		/*calculate watermark height and width from watermark image */
		$watermarkWidth		= imagesx( $watermarkImage );
		$watermarkHeight	= imagesy( $watermarkImage );
		
		/*get original image size */
		$size = getimagesize($imagePath);  
		
		$dest_x = 0;//$size[0] - $watermarkWidth - 5;  
		$dest_y = 0;//$size[1] - $watermarkHeight - 5;
		
		$xy = array();
		$xy[0] = &$dest_x;
		$xy[1] = &$dest_y;
		
		$watermarkSize=array();
		$watermarkSize[0]=$watermarkWidth;
		$watermarkSize[1]=$watermarkHeight;
		self::setPosotion($size,$watermarkSize,$watermarkImage,$position,$xy);
				
		imagecopymerge($imageImage , $watermarkImage, $dest_x, $dest_y, 0, 0, $watermarkSize[0], $watermarkSize[1], 100);
		
		/*first copy the image to tmp location , b'coz we don't want to destroy original image */
		$newImagePath = PROFILETYPE_AVATAR_STORAGE_PATH.DS.$newImageName.'.'.JFile::getExt($imagePath);
		$newImageRefPath = PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.$newImageName.'.'.JFile::getExt($imagePath);
		
		imagesavealpha($imageImage, true);
		// Test if type is png
		if( $destinationType == 'image/png' || $destinationType == 'image/x-png' )
		{
			$output = imagepng( $imageImage, $newImagePath  );
		}
		elseif ( $destinationType == 'image/gif')
		{
			$output = imagegif( $imageImage , $newImagePath );
		}
		else
		{
			// We default to use jpeg
			$output =  imagejpeg($imageImage, $newImagePath ,100);
		}
		
		// Free any memory from the existing image resources
		imagedestroy( $imageImage );
		imagedestroy( $watermarkImage );
		
		return $output ? $newImageRefPath : false;
	}

	/* watermarksize array contain width at 0th index and height at 1st index in array 
	 * imagesize array contain width at 0th index and height at 1st index in array
	 * xy contain x pos at 0th index and y pos at 1st index
	 * */
	function setPosotion($imagesize,&$watermarkSize,&$watermarkImage,$position,$xy)
	{ 
		/*reference of image is always top-left corener */
		switch($position) {
			case 'tl': 
					$xy[0] = 0;
					$xy[1] = 0;
					break;
			case 'tr': 
					$xy[0] = $imagesize[0] - $watermarkSize[0];
					$xy[1] = 0;
					break;
			case 'bl': 
					$xy[0] = 0;
					$xy[1] = $imagesize[1] - $watermarkSize[1];
					break;
			case 'br': 
					$xy[0] = $imagesize[0] - $watermarkSize[0];
					$xy[1] = $imagesize[1] - $watermarkSize[1];
					break;
			/*now we have to rotate image */
			case 'lt': 
					/*if(function_exists('imagerotate'))
						imagerotate($watermarkImage,90*3);*/
					$watermarkImage=self::rotateImage($watermarkImage,$watermarkSize,90*3);
					$xy[0] = 0;
					$xy[1] = 0;
					break;
			case 'lb': 
					$watermarkImage=self::rotateImage($watermarkImage,$watermarkSize,90*3);
					$xy[0] = 0;
					$xy[1] = $imagesize[1] - $watermarkSize[1];
					break;
			case 'rt': 
					$watermarkImage=self::rotateImage($watermarkImage,$watermarkSize,90);
					$xy[0] = $imagesize[0] - $watermarkSize[0];
					$xy[1] = 0;
					break;
			case 'rb': 
					$watermarkImage=self::rotateImage($watermarkImage,$watermarkSize,90);
					$xy[0] = $imagesize[0] - $watermarkSize[0];
					$xy[1] = $imagesize[1] - $watermarkSize[1];
					break;
			case 'lta': 
					$xy[0] = $imagesize[0] - $watermarkSize[0];
					$xy[1] = $imagesize[1] - $watermarkSize[1];
					break;
			case 'rta': 
					$xy[0] = $imagesize[0] - $watermarkSize[0];
					$xy[1] = $imagesize[1] - $watermarkSize[1];
					break;
			case 'lba': 
					$xy[0] = $imagesize[0] - $watermarkSize[0];
					$xy[1] = $imagesize[1] - $watermarkSize[1];
					break;
			case 'rba': 
					$xy[0] = $imagesize[0] - $watermarkSize[0];
					$xy[1] = $imagesize[1] - $watermarkSize[1];
					break;
		}
		
		return;
	}
	
	
	function rotateImage($img, &$watermarkSize, $rotation) 
	{
	  
	  $width = imagesx($img);
	  $height = imagesy($img);
	  switch($rotation) {
	    case 90: $newimg= @imagecreatetruecolor($height , $width );break;
	    case 180: $newimg= @imagecreatetruecolor($width , $height );break;
	    case 270: $newimg= @imagecreatetruecolor($height , $width );break;
	    case 0: return $img;break;
	    case 360: return $img;break;
	  }
	  if($newimg) {
	    for($i = 0;$i < $width ; $i++) {
	      for($j = 0;$j < $height ; $j++) {
	        $reference = imagecolorat($img,$i,$j);
	        switch($rotation) {
	          case 90: if(!@imagesetpixel($newimg, ($height - 1) - $j, $i, $reference )){return false;}break;
	          case 180: if(!@imagesetpixel($newimg, $i, ($height - 1) - $j, $reference )){return false;}break;
	          case 270: if(!@imagesetpixel($newimg, $j, $width - $i, $reference )){return false;}break;
	        }
	      }
	    } 
		$watermarkSize[0]=imagesx($newimg);
		  $watermarkSize[1]=imagesy($newimg);
		 return $newimg;
	  }
	  return false;
	}
	
	
	/*// $src_img - a GD image resource
// $angle - degrees to rotate clockwise, in degrees
// returns a GD image resource
// USAGE:
// $im = imagecreatefrompng('test.png');
// $im = imagerotate($im, 15);
// header('Content-type: image/png');
// imagepng($im);
	function rotateImage($src_img, &$watermarkSize, $angle, $bicubic=false) 
	{
 
   	// convert degrees to radians
	   $angle = $angle + 180;
	   $angle = deg2rad($angle);
	 
	   $src_x = imagesx($src_img);
	   $src_y = imagesy($src_img);
	 
	   $center_x = floor($src_x/2);
	   $center_y = floor($src_y/2);
	
	   $cosangle = cos($angle);
	   $sinangle = sin($angle);
	
	   $corners=array(array(0,0), array($src_x,0), array($src_x,$src_y), array(0,$src_y));
	
	   foreach($corners as $key=>$value) {
	     $value[0]-=$center_x;        //Translate coords to center for rotation
	     $value[1]-=$center_y;
	     $temp=array();
	     $temp[0]=$value[0]*$cosangle+$value[1]*$sinangle;
	     $temp[1]=$value[1]*$cosangle-$value[0]*$sinangle;
	     $corners[$key]=$temp;   
	   }
	  
	   $min_x=1000000000000000;
	   $max_x=-1000000000000000;
	   $min_y=1000000000000000;
	   $max_y=-1000000000000000;
	  
	   foreach($corners as $key => $value) {
	     if($value[0]<$min_x)
	       $min_x=$value[0];
	     if($value[0]>$max_x)
	       $max_x=$value[0];
	  
	     if($value[1]<$min_y)
	       $min_y=$value[1];
	     if($value[1]>$max_y)
	       $max_y=$value[1];
	   }
	
	   $rotate_width=round($max_x-$min_x);
	   $rotate_height=round($max_y-$min_y);
	
	   $rotate=imagecreatetruecolor($rotate_width,$rotate_height);
	   imagealphablending($rotate, false);
	   imagesavealpha($rotate, true);
	
	   //Reset center to center of our image
	   $newcenter_x = ($rotate_width)/2;
	   $newcenter_y = ($rotate_height)/2;
	
	   for ($y = 0; $y < ($rotate_height); $y++) {
	     for ($x = 0; $x < ($rotate_width); $x++) {
	       // rotate...
	       $old_x = round((($newcenter_x-$x) * $cosangle + ($newcenter_y-$y) * $sinangle))
	         + $center_x;
	       $old_y = round((($newcenter_y-$y) * $cosangle - ($newcenter_x-$x) * $sinangle))
	         + $center_y;
	     
	       if ( $old_x >= 0 && $old_x < $src_x
	             && $old_y >= 0 && $old_y < $src_y ) {
	
	           $color = imagecolorat($src_img, $old_x, $old_y);
	       } else {
	         // this line sets the background colour
	         $color = imagecolorallocatealpha($src_img, 255, 255, 255, 127);
	       }
	       imagesetpixel($rotate, $x, $y, $color);
	     }
	   }
	  $watermarkSize[0]=imagesx($rotate);
	  $watermarkSize[1]=imagesy($rotate);
	  return $rotate;
	}
	*/
	
	
	//get params data from xipt component or any
	function getParams($paramName='', $comName='com_xipt', $defaultValue=0)
	{
		$sModel = XiFactory :: getModel('settings');
		$params  = $sModel->getParams();

		if(!$params)
		{
		    JError::raiseWarning('XIPT-SYSTEM-ERROR','JSPT PARAMS ARE NULL');
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
		    XiPTLibraryUtils::XAssert(0);
		    
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
	
	function XAssert($condition, $errMsg="", $severity="ERROR" ,$file=__FILE__, $function=__FUNCTION__,$line=__LINE__)
	{
		static $counter=0;
		if($condition)
		{
			$counter++;
			return true;
		}

		$errMsg .= "\n Filename : $file \n Function : $function \n Line : $line \n ";
		$xiptErrorCode = "XIPT-SYSTEM-ERROR";
		switch($severity)
		{
			case 'ERROR':
				JError::raiseError($xiptErrorCode, $errMsg);
				break;
				
			case 'WARNING':
				JError::raiseWarning($xiptErrorCode, $errMsg);
				break;
				
			case 'NOTICE':
			default:
				JError::raiseNotice($xiptErrorCode, $errMsg);
				break;
		}
		return false;
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