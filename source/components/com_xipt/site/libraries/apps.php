<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTLibraryApps
{
	function getAllowedApps(&$applications,$appname)
	{
		if(!empty($applications)) {
			$i = 0;
			$user = & CFactory::getUser();
			if($user->_userid) {
				$userProfiletypeId = XiPTLibraryProfiletypes::getUserProfiletypeFromUserID($user->_userid);
				foreach($applications as $app) {
					if(!XiPTLibraryProfiletypes::getcheckaccess($app->$appname,$userProfiletypeId))
						unset($applications[$i]);
					$i++;
				}
				$applications = array_values($applications);
			}
		}
	}

	function getcheckaccess($appname,$userProfiletypeId)
	{
			$appsModel = CFactory::getModel('apps');
			$checkaccess = XiPTLibraryProfiletypes::checkAccessofApplication(
			$appsModel->getPluginId( $appname ),$userProfiletypeId);
			return $checkaccess;
	}
	
	
	function checkAccessofApplication($applicationId,$userProfiletypeId)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT ' . $db->nameQuote( 'id' ) . ' '
				. 'FROM ' . $db->nameQuote( '#__xipt_applications' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'applicationid' ) . '=' . $db->Quote( $applicationId ) . ' '
				. 'AND ' . $db->nameQuote( 'profiletype' ) . '=' . $db->Quote( $userProfiletypeId );

		$db->setQuery( $query );

		$result = $db->loadResult();
		
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
		
		if(empty($result))
			return 1;
		else
			return 0;
	
	}
}
