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
			case 'privacy':
				$allValues[] = 'friends';
				$allValues[] = 'members';
				$allValues[] = 'public';
				break;
					
			case 'template' :
					$allValues = XiPTHelperProfiletypes::getBackendTemplatesList();
					break;
			case 'jusertype' :
					$allValues = XiPTHelperProfiletypes::getJUserTypes();
					break;
			case 'group' :
					$allValues = XiPTHelperProfiletypes::getGroups();
					break;
			default:
				assert(0);
		}
	
		$html	= '<span>';
		
		$html	.= '<select  name="'.$what.'"  id="type">';
		
		foreach($allValues as $vals)
		{		
			$selected	= ( trim($value) == $vals ) ? 'selected="true"' : '';
			$html		.= '<option value="' . $vals . '"' . $selected . '>' . ucfirst($vals) . '</option>';
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
				$defaultValue	= 'components/com_community/assets/default.jpg';
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


function addAllExistingUserToProperGroups($pid,$gid, $oldgid)
{
	$db 	=& JFactory::getDBO();
	$sql 	= "SELECT ".$db->nameQuote('params')." FROM #__community_config"
			. " WHERE ".$db->nameQuote('name')."=".$db->Quote('config');
	$db->setQuery($sql);
	$myresult = $db->loadResult();
		
	// if error occurs 
	if($db->getErrorNum())
		JError::raiseError( 500, $db->stderr());

	$myparams = new JParameter($myresult);		
	$default = $myparams->get('profiletypes');
	
	// read community_user table
	$extraSql = '';
	if((int)$default == (int)$pid)
		$extraSql = ' OR '.$db->nameQuote('profiletype').'='.$db->Quote('0');

	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('userid')
				. ' FROM ' . $db->nameQuote( '#__community_users' ) 
				. ' WHERE  '.$db->nameQuote('profiletype').'='.$db->Quote($pid) . $extraSql;
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	
	if(!$results)
		return;
	
	foreach ($results as $user)
	{
		XiPTLibraryProfiletypes::remove_user_from_group($user->userid,$oldgid);
		XiPTLibraryProfiletypes::add_user_to_group($user->userid,$gid);
		
		// this will reset his all properties
		XiPTLibraryProfiletypes::setProfileDataForUserID($user->userid,$pid,'ALL');
	}
}

	function getProfiletypeFieldHTML($value)
	{	
		$required			='1';
		$html				= '';
		$selectedElement	= 0;
		$class				= ($required == 1) ? ' required' : '';
		$elementSelected	= 0;
		$elementCnt	        = 0;
		$options			= XiPTLibraryProfiletypes::getProfileTypesArray();
		
		$config = CFactory::getConfig();
	
		$cnt = 0;
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

}
