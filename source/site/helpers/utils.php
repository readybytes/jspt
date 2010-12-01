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
	
	function getUrlpathFromFilePath($filepath)
	{
		$urlpath = preg_replace('#[/\\\\]+#', '/', $filepath);
		return $urlpath;
	}
	
	static function changePluginState($plugin, $state=0)
	{
		$query = new XiptQuery();
		
		$result= $query->update('#__plugins')
					 ->set(" `published` = $state ")
	          		 ->where(" `element` = '$plugin' ")
	          		 ->dbLoadQuery("","")
	          		 ->query();		
	       return $result;
	}
	
	
	static function getPluginStatus($plugin)
	{
		$query = new XiptQuery();
		return $query->select('*')
					 ->from('#__plugins' )
					 ->where(" `element` = '$plugin' ")
					 ->dbLoadQuery("","")
	          		 ->loadObject();
	}
/**
* Change filePath according to machine.
*/
	function getRealPath($filepath){
	
		if(JString::stristr($filepath,JPATH_ROOT) === false)
			$filepath = JPATH_ROOT.DS.$filepath;
		
		return str_replace(realpath(JPATH_ROOT).DS,"",realpath($filepath));
	}
}
