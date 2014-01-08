<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperApps 
{
	public static function getProfileTypeNames($aid)
	{	
		XiptError::assert($aid, XiptText::_("APPLICATION_ID_CANNOT_BE_NULL"), XiptError::ERROR);

		$selected = XiptHelperApps::getProfileTypeArray($aid);
		
		//if selected is empty means field is invisible, then return none
		if(empty($selected))
			return XiptText::_("NONE");
		
		//if 0 exist in selected ptype means , field is available to all
		if(in_array(XIPT_PROFILETYPE_ALL, $selected))
			return XiptText::_("ALL");
			
		$retVal = array();		
		foreach($selected as $pid)	     		
			$retVal[] = XiptHelperProfiletypes::getProfileTypeName($pid);
		       
		return implode(',',$retVal);
	}   


	public static function getProfileTypeArray($aid)
	{	
		XiptError::assert($aid, XiptText::_("APPLICATION_ID_CANNOT_BE_NULL"), XiptError::ERROR);
		
		$results = XiptFactory::getInstance('applications','model')
								->getProfileTypes($aid);

		if(empty($results)) return array(XIPT_PROFILETYPE_ALL);
		
		$allTypes	= XiptHelperProfiletypes::getProfileTypeArray();
		// array_values is user to arrange the array from index 0, 
		//array_diff uses index starting from 1
		return array_values(array_diff($allTypes, $results));
	}

	public static function buildProfileTypesforApplication( $aid )
	{
		$selectedTypes 	= XiptHelperApps::getProfileTypeArray($aid);		
		$allTypes		= XiptHelperProfiletypes::getProfileTypeArray();
		
		$html	= '';
		
		$html	.= '<span>';
		foreach( $allTypes as $option )
		{
			// XITODO : improve following condition
		  	$selected	= in_array($option , $selectedTypes) || in_array(XIPT_PROFILETYPE_ALL, $selectedTypes)  ? ' checked="checked"' : '';
			$html .= '<lable><input type="checkbox" id="profileTypes'.$option. '" name="profileTypes[]" value="' . $option . '"' . $selected .'" style="margin: 0 5px 5px 0;" />';
			$html .= XiptHelperProfiletypes::getProfileTypeName($option).'</lable>';
			$html .= '<div class="clr"></div>';
		}
		$html	.= '</span>';		
		
		return $html;
	}

	/**
	 * Translate a list of objects
	 *
	 * @param	array The array of objects
	 * @return	array The array of translated objects
	 */
	public static function translate(&$items)
	{
		$lang = JFactory::getLanguage();
		foreach($items as &$item) {
			$source = JPATH_PLUGINS . '/' . $item->folder . '/' . $item->element;
			$extension = 'plg_' . $item->folder . '_' . $item->element;
				$lang->load($extension . '.sys', JPATH_ADMINISTRATOR, null, false, false)
			||	$lang->load($extension . '.sys', $source, null, false, false)
			||	$lang->load($extension . '.sys', JPATH_ADMINISTRATOR, $lang->getDefault(), false, false)
			||	$lang->load($extension . '.sys', $source, $lang->getDefault(), false, false);
			$item->name = JText::_($item->name);
		}
	}
}
