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
	
	function getFieldData( $value )
	{
		//echo "value is ".$value;
		$user = CFactory::getUser();
		if($value)
			return $value;
		else
		{
			if($this->_task != 'registerProfile' &&  $this->_view !='register')
				$tName = XiPTLibraryProfiletypes::getTemplateOfuser($user->_userid);
			else
			{
				//from registration
				if($this->_mySess->has('SELECTED_PROFILETYPE_ID', 'XIPT') 
					&& (($selectedProfiletypeID 
					= $this->_mySess->get('SELECTED_PROFILETYPE_ID',0, 'XIPT'))
				 	!= 0))
				 $pID = $selectedProfiletypeID;
			
				assert($pID) || JError::raiseError('REGERR',JText::_('PLEASE ASK ADMIN TO SET DEFAULT PROFILETYPE THROUGH ADMIN PANEL OTHERWISE THING WILL NOT WORK PROPERLY'));
				
				$tName = XiPTLibraryProfiletypes::getProfileTypeData($pID,'template');
			}
			
			if(empty($tName))
			{
				$config	=& CFactory::getConfig();
				$tName =  $config->get('template');
			}
			return $tName;
		}
	}
	
	function getFieldHTML( $field , $required )
	{
		$tName	= $field->value;
		$templates = XiPTLibraryProfiletypes::getTemplatesList();
		$class	= ($field->required == 1) ? ' required' : '';
		
		$selectedValue = CFieldsTemplates::getFieldData($tName);
		
		$allow_templatechange = $this->_params->get('allow_templatechange',0);
		
		if(!$allow_templatechange) {
			$html = '<input type="hidden" id="field'.$field->id.'" 
				name="field' . $field->id  . '" value="'.$selectedValue.'" >'; 
			$html .= $selectedValue;
			return $html;
		}
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id . '" class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
		if(!empty($templates))
		{
			$selectedElement	= 0;
			foreach($templates as $tmpl)
			{
				$selected	= ( $tmpl == $selectedValue ) ? ' selected="selected"' : '';
				
				if( !empty( $selected ) )
					$selectedElement++;
				
				$html	.= '<option value="' . $tmpl . '"' . $selected . '>' . JText::_( $tmpl ) . '</option>';
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