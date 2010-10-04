<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

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

	function getModel( $name = '', $from='admin')
	{
		return XiptFactory::getInstance($name,'model');
	}

	static function getInstance($name, $type, $prefix='Xipt', $refresh=false)
	{
		static $instance=array();

		//generate class name
		$className	= JString::ucfirst($prefix)
					. JString::ucfirst($type)
					. JString::ucfirst($name);

		// Clean the name
		$className	= preg_replace( '/[^A-Z0-9_]/i', '', $className );

		//if already there is an object
		if($refresh===false && isset($instance[$className]))
			return $instance[$className];

		//class_exists function checks if class exist,
		// and also try auto-load class if it can
		if(class_exists($className, true)===false)
		{
			XiptError::raiseError(500,XiptText::_("Class $className not found"));
			return false;
		}

		//create new object, class must be autoloaded
		$instance[$className]= new $className();

		return $instance[$className];
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
