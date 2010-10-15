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
	function getJUserTypes()
	{
		$values=array();
		$query 	= new XiptQuery();				
		$val	=	$query->select('*')
			  			  ->from('#__core_acl_aro_groups' )
			  			  ->where(" `name` <> 'ROOT' ", 'AND')
			  			  ->where(" `name` <> 'USERS' ", 'AND')
			  			  ->where(" `name` <> 'Public Frontend' ", 'AND')
			  			  ->where(" `name` <> 'Public Backend' ", 'AND')
			  			  ->where(" `name` <> 'Super Administrator' ", 'AND')
			  			  ->dbLoadQuery("","")
			  			  ->loadObjectList('name');
		 
		if($val)
				return array_keys($val);			
		    
		return 'None';	
	}	
}