<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiptHelperProfilefields 
{
	// return row from row id of fields values table
	function getProfileTypeNames($fid,$for)
	{
		XiptHelperUtils::XAssert($fid, "ProfileField Id cannot be null.");

		$selected = XiptHelperProfilefields::getProfileTypeArray($fid,$for);
		
		//if selected is empty means field is invisible, then return none
		if(empty($selected))
			return JText::_("NONE");
		
		//if 0 exist in selected ptype means , field is available to all
		if(in_array(XIPT_PROFILETYPE_ALL, $selected))
			return XiptHelperProfiletypes::getProfileTypeName(0);
			
		$retVal = array();		
		foreach($selected as $pid)
			$retVal[] = XiptHelperProfiletypes::getProfileTypeName($pid);
			   
		return implode(',',$retVal);
	}

	function getProfileTypeArray($fid,$for)
	{
		XiptHelperUtils::XAssert($fid);
			
		//Load all profiletypes for the field
		$results = XiptFactory::getInstance('profilefields','model')
									->getProfileTypes($fid, $for);
		
		if(empty($results)) return array(XIPT_PROFILETYPE_ALL);
			
		$allTypes	= XiptHelperProfiletypes::getProfileTypeArray();
		// array_values is user to arrange the array from index 0, 
		//array_diff uses index starting from 1
		return array_values(array_diff($allTypes, $results));
	}


	function buildProfileTypes( $fid ,$for)
		{
			$selectedTypes 	= XiptHelperProfilefields::getProfileTypeArray($fid,$for);		
			$allTypes		= XiptHelperProfiletypes::getProfileTypeArray(true);
			
			$html			= '';
			$categories		= XiptHelperProfilefields::getProfileFieldCategories();	
			$name			= $categories[$for]['controlName'];
			$html	   	   .= '<span>';
			$count 			= count($allTypes)-1;
			$html 	   	   .= '<input type="hidden" name="'.$name.'Count" value="'.$count.'" />';
			
			foreach( $allTypes as $option )
			{
			    $selected	= in_array($option , $selectedTypes ) ? ' checked="checked"' : '';
				$html .= '<br/><lable><input type="checkbox" name= "'.$name.'' .$option. '" value="' . $option . '"' . $selected .'" style="margin: 0 5px 5px 0;" />';
				$html .= XiptHelperProfiletypes::getProfileTypeName($option).'</lable>';
				$count--;
			}
			$html	.= '</span>';		
			
			return $html;
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
