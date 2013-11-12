<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

//This class contains all logic for XIPT & JomSocial & Joomla Table Communication

class XiptLibJoomla
{
	public static function getJUserTypes()
	{
		$values= array(JOOMLA_USER_TYPE_NONE);
		$query 	= new XiptQuery();
		
		$val	= $query->select('*')
	 		  ->from('#__usergroups' )
	  		  ->dbLoadQuery("","")
	  		  ->loadObjectList('title');
		
		if($val)
			return array_merge($values, array_keys($val)); 		
		    
		return $values;	
	}	
}
