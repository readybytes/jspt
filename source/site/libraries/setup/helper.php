<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptSetupHelper
{
	public static function getOrderedRules()
	{
		$xml		= XIPT_FRONT_PATH_LIBRARY_SETUP . DS . 'order.xml';
		$parser  	= new SimpleXMLElement($xml, NULL, true);
	
		$order	= array();
		$childrens = $parser->children();
		foreach($childrens as $child){
			$order[] = $child->attributes();
		}
		return $order;
	}
}