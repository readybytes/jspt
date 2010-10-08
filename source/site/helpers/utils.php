<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperUtils
{
	function isAdmin($id)
	{
		$my	= CFactory::getUser($id);		
		return ( $my->usertype == 'Super Administrator');
	}
	
	function XAssert($condition, $errMsg="", $severity="ERROR" ,$file=__FILE__, $function=__FUNCTION__,$line=__LINE__)
	{
		static $counter=0;
		if($condition)
		{
			$counter++;
			return true;
		}

		$errMsg .= "\n Filename : $file \n Function : $function \n Line : $line \n ";
		$xiptErrorCode = "XIPT-SYSTEM-ERROR";
		switch($severity)
		{
			case 'ERROR':
				XiptError::raiseError($xiptErrorCode, $errMsg);
				break;
				
			case 'WARNING':
				XiptError::raiseWarning($xiptErrorCode, $errMsg);
				break;
				
			case 'NOTICE':
			default:
				XiptError::raiseNotice($xiptErrorCode, $errMsg);
				break;
		}
		return false;
	}
}
