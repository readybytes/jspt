<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/


// no direct access
if(!defined('_JEXEC')) die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php');
 
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
		$this->_params = XiptFactory::getSettings('', 0);
		
	}

	//TODO : add FormatData and Validate
	
	function getFieldData( $value )
	{
		$userid = JRequest::getVar('userid',0);
		$tName = JText::_(self::getTemplateValue($value,$userid));
		
		/*
		 // add search link
        
	 	$searchLink = CRoute::_('index.php?option=com_community&view=search&task=field&'.
 				TEMPLATE_CUSTOM_FIELD_CODE.'='.urlencode( $tName ) );
		$data = '<a href="'.$searchLink.'">'.$tName.'</a>';
		return $data;//$tName;
		*/
		return $tName;
	}
	
	function getFieldHTML($field, $required )
	{
		// it might be some other user (in case of admin is editing profile)
		$user    =& JFactory::getUser();
		
		$tName	= $field->value;
		$templates = XiptHelperJomsocial::getTemplatesList();
		$class	= ($required == 1) ? ' required' : '';
		
		$selectedValue = JText::_(CFieldsTemplates::getTemplateValue($tName,$user->id));
		//	XITODO : format it in proper way
		$allowToChangeTemplate = XiptHelperProfiletypes::getProfileTypeData(XiptLibProfiletypes::getUserData($user->id),'allowt');
		$allowToChangeTemplate = $allowToChangeTemplate || XiptHelperUtils::isAdmin($user->id);
		
		if(!$allowToChangeTemplate) {
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
	
	
	function getTemplateValue($value,$userid)
	{
		// during registration
        if($this->_view =='register'){
            $pID = XiptFactory::getPluginHandler()->getRegistrationPType();
		    $tName = XiptLibProfiletypes::getProfileTypeData($pID,'template');
		    return $tName;
        }
		
        if($value)
            $tName=$value;
        else
        {
	        //a valid or default value
	        $tName = XiptLibProfiletypes::getUserData($userid,'TEMPLATE');
        }
        return $tName;
	}
}
