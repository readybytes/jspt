<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTHelperProfiletypes 
{
	
	function buildTypes($value, $what)
	{
		$allValues	= array();
		switch($what)
		{
			case 'profiletype':
				$allTypes = XiPTLibraryProfiletypes::getProfiletypeArray();
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
					$templates = XiPTHelperProfiletypes::getBackendTemplatesList();
					if($templates)
						foreach ($templates as $t)
							$allValues[$t]=$t;
					break;
			case 'jusertype' :
					$usertypes= XiPTHelperProfiletypes::getJUserTypes();
					if ($usertypes) 
						foreach ($usertypes as $u)
							$allValues[$u]=$u;
					
					break;
			case 'group' :
					$groups = XiPTHelperProfiletypes::getGroups();
					if ($groups)
						foreach ($groups as $g)
							$allValues[$g->id]=$g->name;
					//We should add none also.
					$allValues['0']='None';
					break;
			default:
				assert(0);
		}
	
		$html	= '<span>';
		
		$html	.= '<select  name="'.$what.'"  id="'.$what.'">';
		
		// we need to check here key=>value
		foreach($allValues as $key=>$val)
		{		
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
		$path	= dirname(JPATH_BASE) . DS . 'components' . DS . 'com_community' . DS . 'templates';
	
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
		return $templates;
	}
	
function getProfileTypeData($id,$what='name')
{
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
				assert(0);
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
	
function getProfileTypeName($id)
{
			
		if($id==0 || empty($id))
			return JText::_("All");

		$db		=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('name')
					. ' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id);
		$db->setQuery( $query );
		return $db->loadResult();
}




function getProfileTypeArray($all = '')
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
		$retVal[] = 0;
		
	return $retVal;
}	


function getJUserTypes()
{
	$values=array();
	$db			=& JFactory::getDBO();
	$query		= 'SELECT * FROM ' . $db->nameQuote( '#__core_acl_aro_groups' );
	$db->setQuery( $query );
	$val = $db->loadObjectList();
	
	if($val)
		foreach ($val as $v)
		{
			if($v->name == 'ROOT' || $v->name == 'USERS'
				|| $v->name == 'Public Frontend' || $v->name == 'Public Backend'
				|| $v->name == 'Administrator' || $v->name == 'Super Administrator'
				)
				continue;
			
			$values[]=$v->name;
		}
	
	return $values;	
}


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
	$allUsers = XiPTLibraryProfiletypes::getAllUsers($pid);
	
	if(!$allUsers)
		return;

	$featuresToReset = array('jusertype','template','group','watermark','privacy','avatar');
	$filteredOldData= array();
	$filteredNewData= array();
	
	foreach ($featuresToReset  as $feature)
	{
		$filteredOldData[$feature]= $oldData->$feature;
		$filteredNewData[$feature]= $newData[$feature];
	}
	
	foreach ($allUsers as $user)
	{
		XiPTLibraryProfiletypes::updateUserProfiletypeFilteredData($user, $featuresToReset, $filteredOldData, $filteredNewData);
	}
}

	function getProfiletypeFieldHTML($value)
	{	
		$required			='1';
		$html				= '';
		$class				= ($required == 1) ? ' required' : '';
		$options			= XiPTLibraryProfiletypes::getProfiletypeArray();
		
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

			$oldFile = XiPTLibraryProfiletypes::getProfiletypeData($id,$what);

			// If old file is default_thumb or default, we should not remove it.
			// Need proper way to test it
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
			
			$db =& JFactory::getDBO();
			//CODREV : now update profiletype with new avatar
			$query	= 'UPDATE ' . $db->nameQuote( '#__xipt_profiletypes' ) . ' '
	    			. 'SET ' . $db->nameQuote( $what ) . '=' . $db->Quote( $image ) . ' '
	    			. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $id );
	    	$db->setQuery( $query );
	    	$db->query( $query );

			if($db->getErrorNum())
			{
				JError::raiseError( 500, $db->stderr());
		    }
		}
	}
}
