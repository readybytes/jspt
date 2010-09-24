<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiFactory
{
	function &getModel( $name = '', $from='admin')
	{
		static $modelInstances = null;
		
		if(!isset($modelInstances[$name]))
		{
			if($from==='admin')
				include_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'
							.DS.'models'.DS. JString::strtolower( $name ) .'.php');
			else
				include_once( JPATH_ROOT.DS.'components'.DS.'com_xipt'
							.DS.'models'.DS. JString::strtolower( $name ) .'.php');
			$classname = 'XiPTModel'.$name;
			$modelInstances[$name] = new $classname;
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
	
	function getUrlpathFromFilePath($filepath)
	{
		$urlpath = preg_replace('#[/\\\\]+#', '/', $filepath);
		return $urlpath;
	}
}
