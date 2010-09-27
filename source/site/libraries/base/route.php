<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt' .DS. 'router.php';

class XiptRoute extends JRoute
{
	function _addItemId($url)
	{
		
		$Jurl     = new JURI($url);
		$query     = $Jurl->getQuery(true);
		
		//already itemid is there
		if(isset($query['Itemid']))
			return $url;
		
		XiptBuildRoute($query);
		
		// no menu there, so we can't add item id
		if(!isset($query['Itemid']))
			return $url;
		
		//we have menu so add it's item id
		return $url."&Itemid=".$query['Itemid'];		
	}
	
	function _($url, $xhtml = true, $ssl = null)
	{
		$config =& JFactory::getConfig();
	
		if(JFactory::getApplication()->isAdmin())
			return $url;
			
		if(strpos($url, 'com_community'))
			return CRoute::_($url,$xhtml, $ssl);
			
		if(strpos($url, 'com_xipt') && $config->getValue('sef') === '0' )
		    $url = self::_addItemId($url);
		
		return parent::_($url, $xhtml, $ssl);
	}
	
}