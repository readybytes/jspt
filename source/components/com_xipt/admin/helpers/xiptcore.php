<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * profilestatus Helper
 *
 * @package Joomla
 * @subpackage profilestatus
 * @since 1.5
 */
class XiFactory
{
	function &getModel( $name = '', $config = array() )
	{
		static $modelInstances = null;
		
		if(!isset($modelInstances[$name]))
		{
			include_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'
							.DS.'models'.DS. JString::strtolower( $name ) .'.php');
			$classname = 'XiPTModel'.$name;
			$modelInstances[$name] =& new $classname;
		}
		
		return $modelInstances[$name];
	}


	function buildRadio($status, $fieldname, $values)
	{
		$html	= '<span>';
		
		if($status || $status == '1'){
			$html	.= '<input type="radio" id="' . $fieldname 
					. '" name="' . $fieldname . '" value="1" checked="checked" />' 
					. $values[0];
			$html	.= '<input type="radio" id="' . $fieldname 
					. '" name="' . $fieldname . '" value="0" />' 
					. $values[1];
		} else {
			$html	.= '<input type="radio" id="' . $fieldname 
					. '" name="' . $fieldname . '" value="1" />' 
					. $values[0];
			$html	.= '<input type="radio" id="' . $fieldname 
					. '" name="' . $fieldname . '" value="0" checked="checked" />' 
					. $values[1];	
		}
		$html	.= '</span>';
		
		return $html;
	}
}
?>