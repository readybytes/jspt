<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license http://www.azrul.com Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

class CFieldsTemplates
{
	var $_mainframe;
	var $_mySess;
	var $_task;
	var $_view;
	var $_params;
	
	function __construct()
	{
		global $mainframe;
		$this->_mainframe =& $mainframe;
		$this->_mySess =& JFactory::getSession();
		$this->_task = JRequest::getVar('task',0,'GET');
		$this->_view = JRequest::getVar('view',0,'GET');
		$this->_params = JComponentHelper::getParams('com_xipt');
		
	}

	//TODO : add FormatData and Validate
	
	function getFieldData( $value )
	{
		$userid = JRequest::getVar('userid',0);
		
		if($value)
            return $value;
        
        //a valid or default value
        $tName = XiPTLibraryProfiletypes::getUserData($userid,'TEMPLATE');
        
        // during registration
        if($this->_task == 'registerProfile' &&  $this->_view =='register'){
            $pID = XiPTFactory::getLibraryPluginHandler()->getRegistrationPType();
		    $tName = XiPTLibraryProfiletypes::getProfileTypeData($pID,'template');
        }
		return $tName;
	}
	
	function getFieldHTML($field, $required )
	{
		$tName	= $field->value;
		$templates = XiPTLibraryUtils::getTemplatesList();
		$class	= ($field->required == 1) ? ' required' : '';
		
		$selectedValue = CFieldsTemplates::getFieldData($tName);
		
		$allow_templatechange = $this->_params->get('allow_templatechange',0);
		
		if(!$allow_templatechange) {
			$html = '<input type="hidden" id="field'.$field->id.'"
				name="field' . $field->id  . '" value="'.$selectedValue.'" />';
			$html .= $selectedValue;
			return $html;
		}
		
		
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id . '" class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
		$selectedElement	= 0;
		if(!empty($templates)){
			foreach($templates as $tmpl){
				$selected	= ( $tmpl == $selectedValue ) ? ' selected="selected"' : '';
				
				if( !empty( $selected ) )
					$selectedElement++;
				
				$html	.= '<option value="' . $tmpl . '"' . $selected . '>' . JText::_( $tmpl ) . '</option>';
			}
		}
		$html	.= '</select>';
		$html   .= '<span id="errfield'.$field->id.'msg" style="display:none;">&nbsp;</span>';
		
		return $html;
	}
}
