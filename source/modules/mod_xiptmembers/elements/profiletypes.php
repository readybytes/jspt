<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

class JElementProfiletypes extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Profiletypes';

	function fetchElement($name, $value, &$node, $control_name)
	{
		//$params = JComponentHelper::getParams('com_xipt');
		$ptypeHtml = $this->getProfiletypeFieldHTML($name,$value);

		return $ptypeHtml;
	}
	

function getProfiletypeFieldHTML($name,$value)
	{	
		$required			='1';
		$html				= '';
		$class				= ($required == 1) ? ' required' : '';
		$options			= XiPTLibraryProfiletypes::getProfiletypeArray();
		if($options){
		$html	.= '<select id="params['.$name.']" name="params['.$name.']" class="hasTip select'.$class.'" title="' . "Select Account Type" . '::' . "Please Select your account type" . '">';
		for( $i = 0; $i < count( $options ); $i++ )
		{
		    $option		= $options[ $i ]->name;
			$id			= $options[ $i ]->id;
		    
		    $selected	= ( JString::trim($id) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $id . '"' . $selected . '>' . $option . '</option>';
		}
		$html	.= '</select>';	
		$html   .= '<span id="errprofiletypemsg" style="display: none;">&nbsp;</span>';
		}
		else
		$html=JText::_('PROFILE TYPE NOT CREATED');
		return $html;
	}

}
