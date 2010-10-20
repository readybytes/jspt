<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperApps 
{
	function getProfileTypeNames($aid)
	{	
		XiptHelperUtils::XAssert($aid, "Application Id cannot be null.");

		$selected = XiptHelperApps::getProfileTypeArray($aid);
		
		//if selected is empty means field is invisible, then return none
		if(empty($selected))
			return JText::_("NONE");
		
		//if 0 exist in selected ptype means , field is available to all
		if(in_array(XIPT_PROFILETYPE_ALL, $selected))
			return JText::_("ALL");
			
		$retVal = array();		
		foreach($selected as $pid)	     		
			$retVal[] = XiptHelperProfiletypes::getProfileTypeName($pid);
		       
		return implode(',',$retVal);
	}   


	function getProfileTypeArray($aid)
	{	
		XiptHelperUtils::XAssert($aid, "Application ID cannot be NULL.");			
		
		$results = XiptFactory::getInstance('applications','model')
								->getProfileTypes($aid);

		if(empty($results)) return array(XIPT_PROFILETYPE_ALL);
		
		$allTypes	= XiptHelperProfiletypes::getProfileTypeArray();
		// array_values is user to arrange the array from index 0, 
		//array_diff uses index starting from 1
		return array_values(array_diff($allTypes, $results));
	}

	function buildProfileTypesforApplication( $aid )
	{
		$selectedTypes 	= XiptHelperApps::getProfileTypeArray($aid);		
		$allTypes		= XiptHelperProfiletypes::getProfileTypeArray(true);
		
		$html	= '';
		
		$html	.= '<span>';
		$count = count($allTypes);
		$html .= '<input type="hidden" name="profileTypesCount" value="'.$count.'" />';
		foreach( $allTypes as $option )
		{
		  	$selected	= in_array($option , $selectedTypes ) ? ' checked="checked"' : '';
			$html .= '<lable><input type="checkbox" name="profileTypes'.$option. '" value="' . $option . '"' . $selected .'" style="margin: 0 5px 5px 0;" />';
			$html .= XiptHelperProfiletypes::getProfileTypeName($option).'</lable>';
		}
		$html	.= '</span>';		
		
		return $html;
	}	
	
//	function buildProfileTypes($apps)
//	{				
//		$allTypes		= XiptHelperProfiletypes::getProfileTypeArray(true);
//
//		foreach($apps as $app){
//			$selectedTypes 	= XiptHelperApps::getProfileTypeArray($app->id);
//			$html[$app->id] = '';
//			foreach( $allTypes as $option )
//			{
//				$allowed 		 = in_array($option , $selectedTypes ) ? true : false;
//			  	$image			 = $allowed ? 'tick' : 'publish_x';
//				$html[$app->id] .= '<td>';
//			  	$html[$app->id] .= '<img src="images/'.$image.'.png" width="16" height="16" border="0" alt="Published" />';
//			  	$html[$app->id] .= '</td>';					  
//			}		
//		}
//		return $html;
//	}	
}
