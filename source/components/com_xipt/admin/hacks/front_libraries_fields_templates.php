<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license http://www.azrul.com Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profiletypes.php');

class CFieldsTemplates
{
	/* Value must be numeric */
	function getFieldData( $value )
	{
		//echo "value is ".$value;
		$user = CFactory::getUser();
		$task = JRequest::getVar('task',0,'GET');
		$view = JRequest::getVar('view',0,'GET');
		if($value)
			return $value;
		else
		{
			if($task != 'registerProfile' &&  $view !='register')
				$tName = CProfiletypeLibrary::getTemplateOfuser($user->_userid);
			else
			{
				$regmodel	= CFactory::getModel('register');
				$mySess =& JFactory::getSession();	
				$token		= $mySess->get('JS_REG_TOKEN','','JOMSOCIAL');
				$tmpUser = $regmodel->getTempUser($token);
				
				$pID =($mySess->has('JSPT') &&  $mySess->has('JSPT_REG_PTYPE','JSPT') ) ? 
							$mySess->get('JSPT_REG_PTYPE',$tmpUser->profiletypes,'JSPT') 
								: $tmpUser->profiletypes ; 
				
				$tName = CProfiletypeLibrary::getProfileTypeData($pID,'template');
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
		$templates = CProfiletypeLibrary::getTemplatesList();
		$class	= ($field->required == 1) ? ' required' : '';
		
		$selectedValue = CFieldsTemplates::getFieldData($tName);
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