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
		$values= array(JOOMLA_USER_TYPE_NONE);
		$query 	= new XiptQuery();		
		if(XIPT_JOOMLA_16)
		{			  $val	=	$query->select('*')
			 		  ->from('#__usergroups' )
			  		  ->dbLoadQuery("","")
			  		  ->loadObjectList('title');
			}		
		elseif(XIPT_JOOMLA_15)
		{		
		$val	=	$query->select('*')
			  			  ->from('#__core_acl_aro_groups' )
			  			  ->where(" `name` <> 'ROOT' ", 'AND')
			  			  ->where(" `name` <> 'USERS' ", 'AND')
			  			  ->where(" `name` <> 'Public Frontend' ", 'AND')
			  			  ->where(" `name` <> 'Public Backend' ", 'AND')
			  			  ->where(" `name` <> 'Super Administrator' ", 'AND')
			  			  ->dbLoadQuery("","")
			  			  ->loadObjectList('name');
		}
		if($val)
			return array_merge($values, array_keys($val)); 		
		    
		return $values;	
	}	
}
