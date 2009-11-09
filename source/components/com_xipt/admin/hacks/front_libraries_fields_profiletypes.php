<?php
/**
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

class CFieldsProfiletypes
{
	/* Value must be numeric */
	var $_mainframe;
	var $_mySess;
	var $_task;
	var $_view;
	
	function __construct()
	{
		global $mainframe;
		$this->_mainframe =& $mainframe;
		$this->_mySess =& JFactory::getSession();
		$this->_task = JRequest::getVar('task',0,'GET');
		$this->_view = JRequest::getVar('view',0,'GET');		
	}
	
	function getFieldData( $value )
	{
		if($value)
			$pID = $value;
		else
		{
			//get value from profiletype field from xipt_users table
			$user = CFactory::getUser();
			if($user->id)
				$pID = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($user->id);
			
			if(!$pID) {
				$pID = XiPTLibraryProfiletypes::getDefaultPTypeId();
				assert($pID) || JError::raiseError('PTYERR',JText::_('PLEASE ASK ADMIN TO SET DEFAULT PROFILETYPE THROUGH ADMIN PANEL OTHERWISE THING WILL NOT WORK PROPERLY'));
			}
		}
		$pName = XiPTLibraryProfiletypes::getProfileTypeNameFromID($pID);
		return $pName;
	}
	
	function getFieldHTML( $field , $required )
	{
		$html	= '';
		$pID	= $field->value;
		$class	= ($field->required == 1) ? ' required' : '';		
		$disabled = '';
		
		if($this->_task == 'registerProfile' &&  $this->_view =='register') {
			//$disabled = 'disabled=disabled';	
			if($this->_mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
			&& (($selectedProfiletypeID = $this->_mySess->get('SELECTED_PROFILETYPE_ID','', 'XIPT'))
				 != ''))
				 $pID = $selectedProfiletypeID;
			
			assert($pID) || JError::raiseError('REGERR',JText::_('PLEASE ASK ADMIN TO SET DEFAULT PROFILETYPE THROUGH ADMIN PANEL OTHERWISE THING WILL NOT WORK PROPERLY'));
				 
			$html = '<input type="hidden" id="field'.$field->id.'" name="field' . $field->id  . '" value="'.$pID.'" >';
			
			$pName = XiPTLibraryProfiletypes::getProfileTypeNameFromID($pID);
			
			$html .= $pName;
			return $html;
		}
		else {
			
			$user	=& JFactory::getUser();
			
			$allow_User_to_change_ptype_after_reg = $this->_params->get('allow_User_to_change_ptype_after_reg',0);
			
			//if not allowed then show disabled view of ptype
			if(!$allow_User_to_change_ptype_after_reg
				 && !XiPTLibraryProfiletypes::isAdmin($user->id)) {
				
				if(!(int)$pID) {
					$pID = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($user->id); 
				
					if(!$pID)
						$pID = XiPTLibraryProfiletypes::getDefaultPTypeId();
					
					assert($pID) || JError::raiseError('PTYERR','PLEASE ASK ADMIN TO SET DEFAULT PROFILETYPE THROUGH ADMIN PANEL OTHERWISE THING WILL NOT WORK PROPERLY');
				} 	
				$pName = XiPTLibraryProfiletypes::getProfileTypeNameFromID($pID);
				return $pName;
			}
		}
		
		$pTypes = XiPTLibraryProfiletypes::getProfileTypesArray();
		
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id  . '" '.$disabled.' class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
		if(!empty($pTypes))
		{
			$selectedElement	= 0;
			foreach($pTypes as $pType)
			{
				$selected	= ( $pType->id == $pID ) ? ' selected="selected"' : '';
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
	
	
	function isValid($value,$required)
	{
		//TODO : ( DONE )is it a valid profile type, check from table
		if(!XiPTLibraryProfiletypes::validateProfiletypeId($value))
			return false;
			
		if(!$value)
			return false;
		
		return true;
	}
	
}