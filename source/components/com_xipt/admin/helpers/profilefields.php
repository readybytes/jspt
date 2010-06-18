<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');


class XiPTHelperProfileFields 
{

//return all fields available in jomsocial
function get_jomsocial_profile_fields($fieldId=0)
{
	//XITODO: Use filter instead of $fieldID ---improve
	$db		=& JFactory::getDBO();
	if($fieldId==0)
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
			. 'ORDER BY ordering';
	else
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
			. 'WHERE ' . $db->nameQuote('id') .'=' .$db->Quote($fieldId);
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
	function getProfileTypeNamesForFieldId($fid,$for)
	{
		XiPTLibraryUtils::XAssert($fid);

		$selected = array();
		$selected = XiPTHelperProfileFields::getProfileTypeArrayForFieldId($fid,$for);
		
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

function getProfileTypeArrayForFieldId($fid,$for)
{
	XiPTLibraryUtils::XAssert($fid);
		
	//Load all profiletypes for the field
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('pid')
				. ' FROM ' . $db->nameQuote( '#__xipt_profilefields' ) 
				. ' WHERE '.$db->nameQuote('fid').'='.$db->Quote($fid)
				. ' AND '.$db->nameQuote('category').'='.$db->Quote($for);
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


function buildProfileTypes( $fid ,$for)
	{
		$selectedTypes 	= XiPTHelperProfileFields::getProfileTypeArrayForFieldId($fid,$for);		
		$allTypes		= XiPTHelperProfiletypes::getProfileTypeArray('ALL');
		
		$html			= '';
		$categories		= XiPTHelperProfileFields::getProfileFieldCategories();	
		$name			= $categories[$for]['controlName'];
		$html	   	   .= '<span>';
		$count 			= count($allTypes)-1;
		$html 	   	   .= '<input type="hidden" name="'.$name.'Count" value="'.$count.'" />';
		
		foreach( $allTypes as $option )
		{
		    $selected	= in_array($option , $selectedTypes ) ? ' checked="checked"' : '';
			$html .= '<br/><lable><input type="checkbox" name= "'.$name.'' .$option. '" value="' . $option . '"' . $selected .'" style="margin: 0 5px 5px 0;" />';
			$html .= XiPTHelperProfiletypes::getProfileTypeName($option).'</lable>';
			$count--;
		}
		$html	.= '</span>';		
		
		return $html;
	}
	
/* 
*/
function addFieldsProfileType($fid, $pid, $for)
{
	$row	=& JTable::getInstance( 'Profilefields' , 'XiPTTable' );
	$data["fid"]=$fid;
	$data["category"]=$for;
	if(is_array($pid))
	{
		foreach($pid as $p)
		{		
			$data["pid"]=$p;	
			$row->bindValues($data);
			$row->store();
		}
	}
	else
	{
		$data["pid"]=$pid;
		$row->bindValues($data);
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

function getProfileFieldCategories()
{
	$categories[PROFILE_FIELD_CATEGORY_ALLOWED] = array(
								'name'=> 'ALLOWED',
								'controlName' => 'allowedProfileType'
								);
								
	$categories[PROFILE_FIELD_CATEGORY_REQUIRED] = array(
								'name'=> 'REQUIRED',
								'controlName' => 'requiredProfileType'
								);
								
	$categories[PROFILE_FIELD_CATEGORY_VISIBLE] = array(
								'name'=> 'VISIBLE',
								'controlName' => 'visibleProfileType'
								);
								
	$categories[PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG] = array(
								'name'=> 'EDITABLE_AFTER_REG',
								'controlName' => 'editableAfterRegProfileType'
								);
								
	$categories[PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG] = array(
								'name'=> 'EDITABLE_DURING_REG',
								'controlName' => 'editableDuringRegProfileType'
								);
	
	return $categories;
}

}
