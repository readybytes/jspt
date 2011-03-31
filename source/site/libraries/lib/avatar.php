<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 */

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptLibAvatar
{
	/**
	 * (on Ajaxcall)Chek if default avatar remove then it say "can not remove default avatar".
	 * @param unknown_type $response
	 * @return string|string
	 */
	static function removeAvatar(&$response)
	{		
		// get user Avatar
		$myCurrnetAvatar= self::getUserAvatar();		
		
		//get User Profile Type and  ProfileType Avatar
		$myPType  		= XiptLibProfiletypes::getUserData(JFactory::getUser()->id, 'PROFILETYPE');
		$myPType_avatar = XiptLibProfiletypes::getProfiletypeData($myPType, 'avatar');

		//Compare User Avatar and Profile-type Avatar
		if(JString::strcmp($myCurrnetAvatar,$myPType_avatar) == 0){
			self::setResponse($response);
			return false;
		}
		return true;
	
	}
	
	/**
	 * return user field ($what) from community user table
	 * @param $what
	 */
	static function getUserAvatar($what='_avatar')
	{
		return CFactory::getUser()->$what;
	}
	/**
	 * if default avatar remove then set response message.
	 * @param unknown_type $response
	 */
	static function setResponse(&$response) {	
		$tmpl		= new CTemplate();
		$content	= XiptText::_('YOU_CANNOT_REMOVE_DEFAULT_AVATAR');
		//Do not required any action.
		$formAction	= '';//		CRoute::_('index.php?option=com_community&view=profile&task=removeAvatar' );
		$actions	= '<form action="' . $formAction . '" method="POST">';
		//$actions	.=	'<input class="button" type="submit" value="' . JText::_('CC_BUTTON_YES') . '" />';
		$actions	.=	'&nbsp;<button class="button" onclick="cWindowHide();return false;">' . XiptText::_('OK') . '</button>';
		$actions	.= '</form>';

		$response->addAssign('cwin_logo', 'innerHTML', JText::_('CC_REMOVE_PROFILE_PICTURE') );
		$response->addScriptCall('cWindowAddContent', $content, $actions);
	}
	
	/**
	 * When user remove Avatar then set to default avatar as profile pix
	 */
	static function removeProfilePicture()
	{
		$userId = JFactory::getUser()->id;
		$pType  = XiptLibProfiletypes::getUserData($userId, 'PROFILETYPE');
		$newPath = XiptLibProfiletypes::getProfiletypeData($pType, 'avatar');
			
		self::_removeProfilePicture($userId,$pType, $newPath);
		JFactory::getApplication()->redirect( CRoute::_( 'index.php?option=com_community&view=profile' , false ) , JText::_('CC_PROFILE_PICTURE_REMOVED') );
		
	}
	
	function _removeProfilePicture( $id ,$pType, $newPath,$type = 'avatar')
	{
		$db = JFactory::getDBO();
		// Test if the record exists.
		$oldAvatar	= self::getUserAvatar();
		
		//If avatar is default then not remove it
		if(JString::stristr( $oldAvatar , $newPath ))
		{
			JFactory::getApplication()->enqueueMessage(XiptText::_("YOU_CANNOT_REMOVE_DEFAULT_AVATAR"));
			return;
		}
		//get avatar_PROFILE-TYPE_thumb.jpg path
		$thumbPath = JString::str_ireplace(".jpg","_thumb.jpg",$newPath);
		
		// create query for update Avatar and thumb
		$query	=   'UPDATE ' . $db->nameQuote( '#__community_users' ) . ' '
			    	.'SET ' . $db->nameQuote( $type ) . '=' . $db->Quote( $newPath ) . ', '
			    			. '`thumb` = '. $db->Quote( $newPath ) . ' '
			    	.'WHERE ' . $db->nameQuote( 'userid' ) . '=' . $db->Quote( $id );
		
		$db->setQuery( $query );
		$db->query( $query );
		    	
		if($db->getErrorNum()){
			JError::raiseError( 500, $db->stderr());
		}
	    
		//get thumb Path
		$oldAvatarThumb	= self::getUserAvatar('_thumb');
		// If old file is default avatar thumb or default avatar , we should not remove it.
		// if old file is not default avatar then remove it.
		// Need proper way to test it
		if(!JString::stristr( $oldAvatar , $newPath ) && !JString::stristr( $oldAvatarThumb , $thumbPath ) )
		{
			// File exists, try to remove old files first.
			$oldAvatar	= XiptHelperUtils::getRealPath( $oldAvatar );	
			$oldAvatarThumb=XiptHelperUtils::getRealPath( $oldAvatarThumb );
			if( JFile::exists( $oldAvatar ) )
			{	
				JFile::delete($oldAvatar);
				JFile::delete($oldAvatarThumb);
			}
		}
		
		return true;
	}
}