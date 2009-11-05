<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license http://www.azrul.com Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

class CFieldsProfiletypes
{
	/* Value must be numeric */
	function getFieldData( $value )
	{
		//echo "value is ".$value;
		$task = JRequest::getVar('task',0,'GET');
		$view = JRequest::getVar('view',0,'GET');
		if($task == 'registerUpdateProfile' &&  $view =='register'){
			$disabled = 'disabled=disabled';
			$mySess =& JFactory::getSession();	
			if($mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
			&& (($selectedProfiletypeID = $mySess->get('SELECTED_PROFILETYPE_ID',0, 'XIPT'))
				 != 0))
				 $pID = $selectedProfiletypeID;
			if($pID)
				return $pID;
			else
				assert(0);
		}
		
		if($value)
			return $value;
		else
		{
			$params = JComponentHelper::getParams('com_xipt');
			$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
			$pID = $defaultProfiletypeID;
			return $pID;
		}
	}
	
	function getFieldHTML( $field , $required )
	{
		$html	= '';
		$pID	= $field->value;
		$class	= ($field->required == 1) ? ' required' : '';
		$task = JRequest::getVar('task',0,'GET');
		$view = JRequest::getVar('view',0,'GET');
		
		$disabled = '';
		
		if($task == 'registerProfile' &&  $view =='register') {
			//$disabled = 'disabled=disabled';
			$mySess =& JFactory::getSession();	
			if($mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
			&& (($selectedProfiletypeID = $mySess->get('SELECTED_PROFILETYPE_ID','XIPT_NOT_DEFINED', 'XIPT'))
				 != 'XIPT_NOT_DEFINED'))
				 $pID = $selectedProfiletypeID;
			
			assert($pID);
				 
			$html = '<input type="hidden" id="field'.$field->id.'" name="field' . $field->id  . '" value="'.$pID.'" >';
			
			$pName = XiPTLibraryProfiletypes::getProfileTypeNameFromID($pID);
			
			$html .= $pName;
			return $html;
		}
		else {
			
			$user	=& JFactory::getUser();
			
			$params = JComponentHelper::getParams('com_xipt');
			$allow_User_to_change_ptype_after_reg = $params->get('allow_User_to_change_ptype_after_reg',0);
			
			//if not allowed then show disabled view of ptype
			if(!$allow_User_to_change_ptype_after_reg
				 && !XiPTLibraryProfiletypes::isAdmin($user->id)) {
				 
				$pName = XiPTLibraryProfiletypes::getProfileTypeNameFromID($pID);
				return $pName;
			}
		}
		
		$pTypes = XiPTLibraryProfiletypes::getProfileTypesArray();
		
		$selectedValue = CFieldsProfiletypes::getFieldData($pID);
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id  . '" '.$disabled.' class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
		if(!empty($pTypes))
		{
			$selectedElement	= 0;
			foreach($pTypes as $pType)
			{
				$selected	= ( $pType->id == $selectedValue ) ? ' selected="selected"' : '';
				if( !empty( $selected ) )
					$selectedElement++;
				
				$html	.= '<option value="' . $pType->id . '"' . $selected . '>' .$pType->name  . '</option>';
			}
			
			if($selectedElement == 0)
			{
				//if nothing is selected, we default the 1st option to be selected.
				$eleName	= 'field'.$field->id;
				$js			=<<< HTML
					   <script type='text/javascript'>
						   var slt = document.getElementById('$eleName');
						   if(slt != null)
						   {
						       slt.options[0].selected = true;
						   }
					   </script>
HTML;
			}
		}
		$html	.= '</select>';
		$html   .= '<span id="errfield'.$field->id.'msg" style="display:none;">&nbsp;</span>';
		
		return $html;
	}
}