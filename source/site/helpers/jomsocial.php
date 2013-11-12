<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperJomsocial
{
	public static function getTemplatesList()
	{	
		$path	= JPATH_ROOT. DS . 'components' . DS . 'com_community' . DS . 'templates';
		
		return $templates = JFolder::folders($path);
	}
	
 	function getReturnURL()
    {
    	$regType = XiptFactory::getSettings('user_reg');
        
        if($regType === 'jomsocial')
           return XiPTRoute::_('index.php?option=com_community&view=register', false);
        
        return XiPTRoute::_('index.php?option=com_users&view=registration', false);
    }

    public static function isSupportedJS()
	{
		$inValid = array('2.4','2.6','2.8');
		$ver = self::get_js_version();
		return  !in_array(JString::substr($ver,0,3), $inValid);
 	}
 	
	public static function get_js_version()
	{	
		$CMP_PATH_ADMIN	= JPATH_ROOT . DS. 'administrator' .DS.'components' . DS . 'com_community';
		
		$xml	 = $CMP_PATH_ADMIN . DS . 'community.xml';
	
		$parser  = new SimpleXMLElement($xml, NULL, true);
		$version = $parser->version;

		return $version;
	}
	
	public static function getFieldId($fieldcode)
	{
		static $results = array();
		
		$reset = XiptLibJomsocial::cleanStaticCache();
		if(isset($results[$fieldcode]) && $reset == false)
			return $results[$fieldcode]['id'];
		
		$query = new XiptQuery();
		$results = $query->select('*')
						 ->from('#__community_fields')
						 ->dbLoadQuery()
						 ->loadAssocList('fieldcode');
						 
		if(array_key_exists($fieldcode, $results))
			return $results[$fieldcode]['id'];		
	}
}
