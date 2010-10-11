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
		$my	= JFactory::getUser($id);		
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
	
	function getFonts()
	{
		$path	= JPATH_ROOT  . DS . 'components' . DS . 'com_xipt' . DS . 'assets' . DS . 'fonts';
	
		jimport( 'joomla.filesystem.file' );
		$fonts = array();
		if( $handle = @opendir($path) )
		{
			while( false !== ( $file = readdir( $handle ) ) )
			{
				if( JFile::getExt($file) === 'ttf')
					//$fonts[JFile::stripExt($file)]	= JFile::stripExt($file);
					$fonts[] = JHTML::_('select.option', JFile::stripExt($file), JFile::stripExt($file));
			}
		}
		return $fonts;
	}	
}
