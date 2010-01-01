<?php

// no direct access
defined('_JEXEC') or die('Restricted access');


class XiPTHelperProfileFields 
{

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
		return false;
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
		XiPTLibraryUtils::XAssert($fid);

		$selected = array();
		$selected = XiPTHelperProfileFields::getProfileTypeArrayForFieldId($fid);
		
		//if selected is empty means field is invisible, then return none
		if(empty($selected))
			return JText::_("NONE");
		
		//if 0 exist in selected ptype means , field is available to all
		if(in_array('0',$selected))
			return XiPTHelperProfiletypes::getProfileTypeName(0);
			
		$retVal = '';
		
		foreach($selected as $pid) {
		   //echo $pid;
	     		if(in_array($pid,$selected)) {
			        $retVal .= XiPTHelperProfiletypes::getProfileTypeName($pid);
			        $retVal .=','; 
			    }
		}
		       
		return $retVal;
	}

function getProfileTypeArrayForFieldId($fid)
{
	XiPTLibraryUtils::XAssert($fid);
		
	//Load all profiletypes for the field
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('pid')
				. ' FROM ' . $db->nameQuote( '#__xipt_profilefields' ) 
				. ' WHERE '.$db->nameQuote('fid').'='.$db->Quote($fid);
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	
	$allTypes		= XiPTHelperProfiletypes::getProfileTypeArray();
	
	$notselected = array();
	$selected = array();
	//means there is no bound ptype , so we will retrun all ptypes
	//we store ptype that is not required for that field
	//so empty results means field is applicable to all.
	if(empty($results)) {
		$selected[] = 0;
		return $selected;
		//return $allTypes;
	}
		
	
	//if none exist in result then return empty array
	if(in_array('XIPT_NONE',$notselected))
		return $selected;
	
	if($results)
		foreach ($results as $result)
			$notselected[]=$result->pid;

	foreach($allTypes as $pid) {
		   //echo $pid;
	     		if(!in_array($pid,$notselected)) 
			        $selected[] = $pid;
	}
	
	return $selected;
}


function buildProfileTypes( $fid )
	{
		$selectedTypes 	= XiPTHelperProfileFields::getProfileTypeArrayForFieldId($fid);		
		$allTypes		= XiPTHelperProfiletypes::getProfileTypeArray('ALL');
		
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
