<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

//require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profiletypes.php' );
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

/**
 * profilestatus Helper
 *
 * @package Joomla
 * @subpackage profilestatus
 * @since 1.5
 */
class XiPTHelperProfileFields {

//return all fields available in jomsocial
function get_jomsocial_profile_fields()
{
	$db		=& JFactory::getDBO();
		
	$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
			. 'ORDER BY ordering';
			
	$db->setQuery( $query );
	
	$result = $db->loadObjectlist();
	if(!empty($result))
		return $result;
	else
		false;
}

//return fieldname form field id from community fields table
function get_fieldname_from_fieldid($fieldId)
{
	
	$db		=& JFactory::getDBO();
		
	$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
			. 'WHERE `id`='. $db->Quote($fieldId);
			
	$db->setQuery( $query );
	
	$result = $db->loadObjectList();

	if(!empty($result[0]->name))
		return $result[0]->name;
	else
		return $result[0]->fieldcode;;
}

// return row from row id of fields values table
function getProfileTypeNamesForFieldId($fid)
{
	if(empty($fid))
		return "NONE";
		
	//Load all profiletypes for the field
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('pid')
				. ' FROM ' . $db->nameQuote( '#__XiPT_profilefields' ) 
				. ' WHERE '.$db->nameQuote('fid').'='.$db->Quote($fid);
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	
	if(!$results)
		return "NONE";
	
	$retVal = '';
	$i=0;
	foreach($results as $result)
	{
		if($i)
			$retVal .=',';
		
		$retVal .= XiPTHelperProfiletypes::getProfileTypeName($result->pid);
		$i++;
	}
	return $retVal;
}
function getProfileTypeArrayForFieldId($fid)
{
	$retVal	= array();
	if(empty($fid))
	{
		$retVal[] = -1;
		return $retVal;
	}
		
	//Load all profiletypes for the field
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('pid')
				. ' FROM ' . $db->nameQuote( '#__XiPT_profilefields' ) 
				. ' WHERE '.$db->nameQuote('fid').'='.$db->Quote($fid);
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	
	
	if($results)
		foreach ($results as $result)
		{
			//print_r($result);
			$retVal[]=$result->pid;
		}
	return $retVal;
}


function buildProfileTypes( $fid )
	{
		$selectedTypes 	= XiPTHelperProfileFields::getProfileTypeArrayForFieldId($fid);		
		$allTypes		= XiPTHelperProfiletypes::getProfileTypeArray();
		// Add ALL also
		$allTypes[] = 0;
		
		$html	= '';
		
		$html	.= '<span>';
		$count = count($allTypes)-1;
		$html .= '<input type="hidden" name="profileTypesCount" value="'.$count.'" />';
		foreach( $allTypes as $option )
		{
		    $selected	= in_array($option , $selectedTypes ) ? ' checked="checked"' : '';
			$html .= '<lable><input type="checkbox" name="profileTypes'.$option. '" value="' . $option . '"' . $selected .'" style="margin: 0 5px 5px 0;" />';
			$html .= XiPTHelperProfiletypes::getProfileTypeName($option).'</lable>';
			$count--;
		}
		$html	.= '</span>';		
		
		return $html;
	}
	
/* 
*/
function addFieldsProfileType($fid, $pid)
{
	$row	=& JTable::getInstance( 'Profilefields' , 'XiPTTable' );
	if(is_array($pid))
	{
		foreach($pid as $p)
		{			
			$row->bindValues($fid,$p);
			$row->store();
		}
	}
	else
	{
		$row->bindValues($fid,$pid);
		$row->store();
	}
}

function remFieldsProfileType($fid)
{
	if(empty($fid))
		return;
	$row	=& JTable::getInstance( 'Profilefields' , 'XiPTTable' );
	$row->resetFieldId($fid);
}


}
?>