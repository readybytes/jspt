<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperUtils
{
	public static function isAdmin($id)
	{
		if(!$id){
			return false;
		}
		
		return JFactory::getUser($id)->authorise('core.login.admin');
	}
	
	public static function getFonts()
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
	
	public static function getUrlpathFromFilePath($filepath)
	{
		$urlpath = preg_replace('#[/\\\\]+#', '/', $filepath);
		return $urlpath;
	}
	
	public static function changePluginState($plugin, $state=0)
	{
		$query = new XiptQuery();
		
		$result= $query->update('#__extensions')
				 ->set(" `enabled` = $state ")
          		 ->where(" `element` = '$plugin' ")
          		 ->dbLoadQuery("","")
          		 ->query();
	          		 	
	    return $result;
	}
	
	
	public static function getPluginStatus($plugin)
	{
		$query = new XiptQuery();
		
		return $query->select('*')
				 ->from('#__extensions' )
				 ->where(" `element` = '$plugin' ")
				 ->dbLoadQuery("","")
          		 ->loadObject();
	}
/**
* Change filePath according to machine.
*/
	public static function getRealPath($filepath, $seprator = DS)
	{ 
		return JPath::clean($filepath, $seprator);
	
	}
	
/**
	get field value of $userId accordimg to $fieldCode
*/
	public function getInfo($userId, $fieldCode )
	{
		// Run Query to return 1 value
		$db		= JFactory::getDBO();
		$query	= 'SELECT b.* FROM ' . $db->quoteName( '#__community_fields' ) . ' AS a '
				. 'INNER JOIN ' . $db->quoteName( '#__community_fields_values' ) . ' AS b '
				. 'ON b.' . $db->quoteName( 'field_id' ) . '=a.' . $db->quoteName( 'id' ) . ' '
				. 'AND b.' . $db->quoteName( 'user_id' ) . '=' . $db->Quote( $userId ) . ' '
				. 'INNER JOIN ' . $db->quoteName( '#__community_users' ) . ' AS c '
				. 'ON c.' . $db->quoteName( 'userid' ) . '= b.' . $db->quoteName( 'user_id' ) 
				. 'WHERE a.' . $db->quoteName( 'fieldcode' ) . ' =' . $db->Quote( $fieldCode ); 
		
		$db->setQuery( $query );
		$result	= $db->loadObject();

		$field	= JTable::getInstance( 'FieldValue' , 'CTable' );
		$field->bind( $result );
		
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
		
		$config	= CFactory::getConfig();

		// @rule: Only trigger 3rd party apps whenever they override extendeduserinfo configs
		if( $config->getBool( 'extendeduserinfo' ) )
		{
			CFactory::load( 'libraries' , 'apps' );
			$apps	= CAppPlugins::getInstance();
			$apps->loadApplications();
			
			$params		= array();
			$params[]	= $fieldCode;
			$params[]	=& $field->value;
			
			$apps->triggerEvent( 'onGetUserInfo' , $params );
		}

		// Respect privacy settings.
		if(!XIPT_JOOMLA_15){
			$my	= CFactory::getUser();
			CFactory::load( 'libraries' , 'privacy' );
			if( !CPrivacy::isAccessAllowed( $my->id , $userId , 'custom' , $field->access ) ){
				return false;
			}
		}
		
		return $field->value;
	}
	
	// For user avatars that are stored in a remote location, we should return the proper path.
	// firstly we will check if avatar exist locally
	public static function getAvatarPath($avatar)
	{
		$config	 = CFactory::getConfig();
		$photoStorage = $config->getString('photostorage');
		
		$avatarPath = JPATH_ROOT.DS.self::getRealPath($avatar);
		
		if(JFile::exists($avatarPath))
		{
			return JURI::root().self::getUrlpathFromFilePath($avatar);
		}
		
		if( $photoStorage != 'file' && !empty($avatar) )
		{
			$storage = CStorage::getStorage($photoStorage);
			return $storage->getURI( $avatar );
		}

	}
}
