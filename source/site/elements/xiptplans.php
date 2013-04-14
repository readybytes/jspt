<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementXiptPlans extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'xiptPlans';

	function fetchElement($name, $value, &$node, $control_name)
	{
		if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_payplans'))
  			return XiptText::_("PAYPLANS_DOES_NOT_EXISTS");
		
		require_once JPATH_ROOT.DS.'components'.DS.'com_payplans'.DS.'includes'.DS.'api.php';
		
		$attr		 = ' ';
		$ctrl		 = $control_name.'['.$name.']';
		$options	 = PayplansApi::getPlans();
		
		if(isset($node->_attributes->addnone) || isset($node->_attributes['addnone'])){
			$reqnone 			= new stdClass();
			$reqnone->plan_id 	= -1;
			$reqnone->title 	= 'None';
			$options[] 			= $reqnone;
		}
			
		if(isset($node->_attributes->addall) || isset($node->_attributes['addall'])){
			$reqall 			= new stdClass();
			$reqall->plan_id 	= 0;
			$reqall->title 		= 'All';
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
 				
		return JHtml::_('select.genericlist', $options, $ctrl, $attr, 'plan_id', 'title', $selected, $control_name.$name);
	}
}