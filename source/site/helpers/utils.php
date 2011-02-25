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
		if (XIPT_JOOMLA_15)		
			return ( $my->usertype == 'Super Administrator');
		if (XIPT_JOOMLA_16)
			return ( $my->usertype == 'deprecated');
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
		if (XIPT_JOOMLA_16){
			$result= $query->update('#__extensions')
					 ->set(" `enabled` = $state ")
	          		 ->where(" `element` = '$plugin' ")
	          		 ->dbLoadQuery("","")
	          		 ->query();
		}
		if (XIPT_JOOMLA_15){
			$result= $query->update('#__plugins')
					 ->set(" `published` = $state ")
	          		 ->where(" `element` = '$plugin' ")
	          		 ->dbLoadQuery("","")
	          		 ->query();
		}		
	       return $result;
	}
	
	
	static function getPluginStatus($plugin)
	{
		$query = new XiptQuery();
		if (XIPT_JOOMLA_16){
			return $query->select('*')
					 ->from('#__extensions' )
					 ->where(" `element` = '$plugin' ")
					 ->dbLoadQuery("","")
	          		 ->loadObject();
		}
		if (XIPT_JOOMLA_15){
			return $query->select('*')
					 ->from('#__plugins' )
					 ->where(" `element` = '$plugin' ")
					 ->dbLoadQuery("","")
	          		 ->loadObject();
		}
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
