<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiptFactory
{
    /* This classes required a object to be created first.*/
    function getLibraryPluginHandler()
    {
        static $instance =null;
        
        if($instance==null)
            $instance = new XiptLibPluginhandler();
        
        return $instance;
    }
    
    function getXiptUser($userid)
    {
        static $instance = array();
        
        if(!$userid)
            return null;
        
        if($instance[$userid])
            return $instance[$userid];
        
        require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'models'.DS.'user.php';
        
        $instance[$userid] = new XiptModelUser($userid);
        return $instance[$userid];
    }

	function &getModel( $name = '', $from='admin')
	{
		static $modelInstances = null;
		
		if(!isset($modelInstances[$name]))
		{
//			if($from==='admin')
//				include_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'
//							.DS.'models'.DS. JString::strtolower( $name ) .'.php');
//			else
//				include_once( JPATH_ROOT.DS.'components'.DS.'com_xipt'
//							.DS.'models'.DS. JString::strtolower( $name ) .'.php');
			$classname = 'XiptModel'.$name;
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
