<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperProfiletypes 
{
	//XITODO : Clean the function. Remove Switch
	function buildTypes($value, $what,$multiselect=false)
	{
		$allValues	= array();
		switch($what)
		{
			case 'profiletype':
				$allTypes = XiptLibProfiletypes::getProfiletypeArray();
				if ($allTypes)
						foreach ($allTypes as $ptype)
							$allValues[$ptype->id]=$ptype->name;
				break;

			case 'privacy':
				$allValues['friends'] = 'friends';
				$allValues['members'] = 'members';
				$allValues['public'] = 'public';
				break;
					
			case 'template' :
					$templates = XiptHelperProfiletypes::getBackendTemplatesList();
					if($templates)
						foreach ($templates as $t)
							$allValues[$t]=$t;
					break;
			case 'jusertype' :
					$usertypes= XiptHelperProfiletypes::getJUserTypes();
					if ($usertypes) 
						foreach ($usertypes as $u)
							$allValues[$u]=$u;
					
					break;
			case 'group' :
					$groups = XiptHelperProfiletypes::getGroups();
					if ($groups)
						foreach ($groups as $g)
							$allValues[$g->id]=$g->name;
					//We should add none also.
					$allValues['0']='None';
					break;
			default:
				XiptHelperUtils::XAssert(0);
		}
	
		//XITODO : Uset JHTML to build html
		$html   	= '<span>';
		$multiple   ='';
		$size ='';
		if($multiselect==true)
		{
			$multiple ='multiple';
			$what.='[]';
			$value=explode(',',$value);
			$size="size=3";
		}
		$html	.= '<select '.$multiple.' name="'.$what.'"  id="'.$what.'"'.$size.'>';
		
		// we need to check here key=>value
		foreach($allValues as $key=>$val)
		{	
			if(is_array($value))
				$selected	= ( in_array($key, $value) ) ? 'selected="true"' : '';
			else
				$selected	= ( trim($value) == $key ) ? 'selected="true"' : '';
			
			$html		.= '<option value="' . $key . '"' . $selected . '>' . ucfirst($val) . '</option>';
		}
		
		$html	.= '</span>';		
		return $html;
	}
	
	
	
	function getGroups($id='')
	{
		$db			=& JFactory::getDBO();
		
		if(!empty($id))
			$extraSql 	= ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id).' ' ;
		else
			$extraSql	= '';
			
		$query		= 'SELECT '.$db->nameQuote('id').' , '.$db->nameQuote('name')
					.' FROM ' . $db->nameQuote( '#__community_groups' )
					.$extraSql ;
		$db->setQuery( $query );
		if(empty($id))
			$rows = $db->loadObjectList();
		else
			$rows = $db->loadObject();	
		
		/* TODO : what if group list is empty */
		return $rows;
	}
	

	function getBackendTemplatesList()
	{
		return XiptHelperRegistration::getTemplatesList();
		/*$path	= JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'templates';
	
		$handle = @opendir($path);
		if($handle)
		{
			while( false !== ( $file = readdir( $handle ) ) )
			{
				// Do not get '.' or '..' or '.svn' since we only want folders.
				if( $file != '.' && $file != '..' && $file != '.svn' )
					$templates[]	= $file;
			}
		}
		return $templates;*/
	}
	
function getProfileTypeData($id,$what='name')
{
	//XITODO : Caching can be added
	$searchFor 		= 'name';
	$defaultValue	= 'NONE';
	
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
		case  'allowt':
				$searchFor 		= 'allowt';
				$defaultValue	= false;
				break;
		case  'group':
				$searchFor 		= 'group';
				$defaultValue	=  '0';
				break;
		default	:
				XiptHelperUtils::XAssert(0);
	}

	if($id==0)
		return $defaultValue;
		
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '. $db->nameQuote($searchFor) .' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
				. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id) ;
	$db->setQuery( $query );
	$val = $db->loadResult();
	return $val;
}
	
function getProfileTypeName($id,$isNoneReq=false)
{
		//XITODO : Clean ALL / NONE, and cache results
		if($id==0 || empty($id))
			return JText::_("All");
			
		if($isNoneReq && $id==-1)
			return JText::_("NONE");

		$db		=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('name')
					. ' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id);
		$db->setQuery( $query );
		return $db->loadResult();
}




function getProfileTypeArray($all = '',$none= '')
{
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('id').' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) ;
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	$retVal	= array();
	if($results)
		foreach ($results as $result)
			$retVal[]=$result->id;
	
	//add all value also
	if($all == 'ALL')
		$retVal[] = XIPT_PROFILETYPE_ALL;
		
	if($none == 'NONE')
		$retVal[] = XIPT_PROFILETYPE_NONE;
		
	return $retVal;
}	

//XITODO : move to joomla library
function getJUserTypes()
{
	$values=array();
	$db			=& JFactory::getDBO();
	$query		= 'SELECT * FROM ' . $db->nameQuote( '#__core_acl_aro_groups' );
	$db->setQuery( $query );
	$val = $db->loadObjectList();
	
    //XITODO : remove this loop
	if($val)
		foreach ($val as $v)
		{
			//XITODO : improve performance use, array_diff
			if($v->name == 'ROOT' || $v->name == 'USERS'
				|| $v->name == 'Public Frontend' || $v->name == 'Public Backend'
				|| $v->name == 'Administrator' || $v->name == 'Super Administrator'
				)
				continue;
			
			$values[]=$v->name;
		}
	      $values[] = 'None';
	return $values;	
}

//XITODO : rename function, clean it
function addProfileTypeInfroForAll($fID)
{
	// read community_user table
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('userid').', '.$db->nameQuote('profiletype')
				. ' FROM ' . $db->nameQuote( '#__community_users' );
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	
	$obj			= new stdClass();
	// add infor for every user in field table
	
	if(!$results)
		return;
	
	foreach ($results as $v)
		{
			$obj->user_id	= $v->userid;
			$obj->field_id 	= $fID;
			// if ZERO get from configuration
			if($v->profiletype == 0)
			{
				$sql = "SELECT ".$db->nameQuote("params"). " FROM #__community_config"
						." WHERE ".$db->nameQuote("name")."=".$db->Quote("config");
				$db->setQuery($sql);
				$myresult = $db->loadResult();
				$myparams = new JParameter($myresult);		
				$v->profiletype= $myparams->get('profiletypes','0');
			}
			$obj->value		= getProfileTypeData($v->profiletype,'name');

			//XITODO : why we are insterting again n again
			$db->insertObject( '#__community_fields_values' , $obj );
		}
}

/**
 * The function will reapply attributes to every user of profiletype $pid
 * IMP : if user have custom avatar, then it will not be updated
 * IMP : we will re-apply watermark on custom avatar
 * IMP : Users other attribute will be reset irrespective of there settings 
 *
 * @param $pid
 * @param $oldData
 * @param $newData
 * @return unknown_type
 */
function resetAllUsers($pid, $oldData, $newData)
{
	$allUsers = XiptLibProfiletypes::getAllUsers($pid);
	
	if(!$allUsers)
		return;

	$featuresToReset = array('jusertype','template','group','watermark','privacy','avatar');
	$filteredOldData= array();
	$filteredNewData= array();
	
	foreach ($featuresToReset  as $feature)
	{
		$filteredOldData[$feature]= $oldData->$feature;
		$filteredNewData[$feature]= $newData->$feature;
	}
	
	foreach ($allUsers as $user)
	{
		XiptLibProfiletypes::updateUserProfiletypeFilteredData($user, $featuresToReset, $filteredOldData, $filteredNewData);
	}
}

	function getProfiletypeFieldHTML($value)
	{	
		$required			='1';
		$html				= '';
		$class				= ($required == 1) ? ' required' : '';
		$options			= XiptLibProfiletypes::getProfiletypeArray();
		
		$html	.= '<select id="params[defaultProfiletypeID]" name="params[defaultProfiletypeID]" class="hasTip select'.$class.'" title="' . "Select Account Type" . '::' . "Please Select your account type" . '">';
		for( $i = 0; $i < count( $options ); $i++ )
		{
		    $option		= $options[ $i ]->name;
			$id			= $options[ $i ]->id;
		    
		    $selected	= ( JString::trim($id) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $id . '"' . $selected . '>' . $option . '</option>';
		}
		$html	.= '</select>';	
		$html   .= '<span id="errprofiletypemsg" style="display: none;">&nbsp;</span>';
		
		return $html;
	}

	
	function uploadAndSetImage($file,$id,$what)
	{
		global $mainframe;
		CFactory::load( 'helpers' , 'image' );
		$config			= CFactory::getConfig();
		$uploadLimit	= (double) $config->get('maxuploadsize');
		$uploadLimit	= ( $uploadLimit * 1024 * 1024 );

		// @rule: Limit image size based on the maximum upload allowed.
		if( filesize( $file['tmp_name'] ) > $uploadLimit )
		{
			$mainframe->enqueueMessage( JText::_('IMAGE FILE SIZE EXCEEDED') , 'error' );
			$mainframe->redirect( CRoute::_('index.php?option=com_xipt&view=profiletypes&task=edit&editId='.$id, false) );
		}
		
		if( !cValidImage($file['tmp_name'] ) )
		{
			$mainframe->enqueueMessage(JText::_('IMAGE FILE NOT SUPPORTED'), 'error');
		}
		else
		{
			switch($what) {
				case 'avatar':
					$imageMaxWidth	= AVATAR_WIDTH;
					$thumbWidth 	= AVATAR_WIDTH_THUMB;
					$thumbHeight 	= AVATAR_HEIGHT_THUMB;
					$imgPrefix 		= 'avatar_';
					break;
				case 'watermark':
					$imageMaxWidth	= WATERMARK_WIDTH;
					$thumbWidth 	= WATERMARK_WIDTH_THUMB;
					$thumbHeight 	= WATERMARK_HEIGHT_THUMB;
					$imgPrefix 		= 'watermark_';
					break;
			}
			
			$storage			= PROFILETYPE_AVATAR_STORAGE_PATH;
			$storageImage		= $storage . DS .$imgPrefix. $id . cImageTypeToExt( $file['type'] );
			$storageThumbnail	= $storage . DS . $imgPrefix . $id.'_thumb' . cImageTypeToExt( $file['type'] );
			$image				= PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.$imgPrefix . $id . cImageTypeToExt( $file['type'] );
			//$thumbnail			= PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH . $imgPrefix . $id.'_thumb' . cImageTypeToExt( $file['type'] );
			
			//here check if folder exist or not. if not then create it.
			if(JFolder::exists($storage)==false)
				JFolder::create($storage);

			// Only resize when the width exceeds the max.
			if( !cImageResizePropotional( $file['tmp_name'] , $storageImage , $file['type'] , $imageMaxWidth ) )
			{
				$mainframe->enqueueMessage(JText::sprintf('ERROR MOVING UPLOADED FILE' , $storageImage), 'error');
			}

			// Generate thumbnail
			if(!cImageCreateThumb( $file['tmp_name'] , $storageThumbnail , $file['type'],$thumbWidth,$thumbHeight ))
			{
				$mainframe->enqueueMessage(JText::sprintf('ERROR MOVING UPLOADED FILE' , $storageThumbnail), 'error');
			}			

			$oldFile = XiptLibProfiletypes::getProfiletypeData($id,$what);

			// If old file is default_thumb or default, we should not remove it.
			if(!Jstring::stristr( $oldFile , DEFAULT_AVATAR ) 
				&& !Jstring::stristr( $oldFile , DEFAULT_AVATAR_THUMB ) 
					&& $oldFile != $image
					&& $oldFile != ''){
				// File exists, try to remove old files first.
				$oldFile	= JString::str_ireplace( '/' , DS , $oldFile );

				//only delete when required
				if(JFile::exists($oldFile))			
					JFile::delete($oldFile);
			}
			
			//here due to extension mismatch we can break the functionality of avatar
			if($what === 'avatar')
			{
				$newAvatar	= $image;
				/* No need to update thumb here , script will update both avatar and thumb */
				//$newThumb   = XiptHelperImage::getThumbAvatarFromFull($newAvatar);
				$oldAvatar  = XiptLibProfiletypes::getProfiletypeData($id,'avatar');
					
				$allUsers = XiptLibProfiletypes::getAllUsers($id);
				if($allUsers) {
					
					$filter[] = 'avatar';
					$newData['avatar'] = $newAvatar;
					$oldData['avatar'] = $oldAvatar;  
					foreach ($allUsers as $userid)
						XiptLibProfiletypes::updateUserProfiletypeFilteredData($userid, $filter, $oldData, $newData);

				}		    			
			}
			
			//now update profiletype with new avatar or watermark
			$db =& JFactory::getDBO();
			$query	= 'UPDATE ' . $db->nameQuote( '#__xipt_profiletypes' ) . ' '
	    			. 'SET ' . $db->nameQuote( $what ) . '=' . $db->Quote( $image ) . ' '
	    			. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $id );
	    	$db->setQuery( $query );
	    	$db->query( $query );

			if($db->getErrorNum())
			{
				XiptError::raiseError( 500, $db->stderr());
		    }
		}
	}
	
	//XITODO  : move to HelperUtils
	function getFonts()
	{
		$path	= JPATH_ROOT  . DS . 'components' . DS . 'com_xipt' . DS . 'assets' . DS . 'fonts';
	
		jimport( 'joomla.filesystem.file' );
		$fonts = array();
		if( $handle = @opendir($path) )
		{
			while( false !== ( $file = readdir( $handle ) ) )
			{
				if( JFile::getExt($file) === 'ttf')
					//$fonts[JFile::stripExt($file)]	= JFile::stripExt($file);
					$fonts[] = JHTML::_('select.option', JFile::stripExt($file), JFile::stripExt($file));
			}
		}
		return $fonts;
	}
	
	
	function checkSessionForProfileType()
    {   	
    	$mySess = & JFactory::getSession();
    	if($mySess)
			return true;

		// session expired, redirect to community page
		$redirectUrl	= XiptRoute::_('index.php?option=com_community&view=register',false);
		$msg 			= JText::_('YOUR SESSION HAVE BEEN EXPIRED, PLEASE PERFORM THE OPERATION AGAIN');
    	global $mainframe;
		$mainframe->redirect($redirectUrl,$msg);
    }
        
	//XITODO : Remove funda of return url, use configuration
    function setProfileTypeInSession($selectedProfiletypeID)
    {
    	global $mainframe;
    	$mySess = & JFactory::getSession();
    	$redirectUrl = XiptHelperRegistration::getReturnURL();

			// validate values
			if(!XiptLibProfiletypes::validateProfiletype($selectedProfiletypeID)) {
				$msg = JText::_('PLEASE ENTER VALID PROFILETYPE');
				$mainframe->redirect('index.php?option=com_xipt&view=registration',$msg);
				return;
			}
			
			//set value in session and redirect to destination url
			$mySess->set('SELECTED_PROFILETYPE_ID',$selectedProfiletypeID, 'XIPT');
			$mainframe->redirect($redirectUrl);
    }
}