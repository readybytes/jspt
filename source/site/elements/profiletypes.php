<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

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
		$attr		 = ' ';
		$ctrl		 = $control_name.'['.$name.']';
		$options	 = XiptLibProfiletypes::getProfiletypeArray();
		
		if(isset($node->_attributes->addnone) || isset($node->_attributes['addnone'])){
			$reqnone 		= new stdClass();
			$reqnone->id 	= -1;
			$reqnone->name 	= 'None';
			$options[] 		= $reqnone;
		}
			
		if(isset($node->_attributes->addall) || isset($node->_attributes['addall'])){
			$reqall 		= new stdClass();
			$reqall->id 	= 0;
			$reqall->name 	= 'All';
			array_unshift($options, $reqall);
		}
			
		if ($size = $node->attributes( 'size' ))
            $attr  .= 'size="'.$size.'"';
        
		if(isset($node->_attributes->multiselect) || isset($node->_attributes['multiselect'])){
			$attr  .= ' multiple="multiple"';
			$ctrl  .= '[]';
		}
		
		if(is_string($value))
 			$selected = explode('|', $value);
 		else
 			$selected = $value;
 				
		return JHtml::_('select.genericlist', $options, $ctrl, $attr, 'id', 'name', $selected, $control_name.$name);
	}
}