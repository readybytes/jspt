<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTHelperAclRules 
{


	function _buildTypesforAclRules($value, $what)
	{
		$allValues	= array();
		switch($what)
		{
			case 'feature':
				$allValues = XiPTHelperAclRules::_getDisplayNameofAclFeature();
				break;
			
			case 'profiletype' :
			case 'otherprofiletype' :
				$db			=& JFactory::getDBO();
				$query		= 'SELECT id FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) ;
				$db->setQuery( $query );
				$results = $db->loadObjectList();
				if($results)
				{
					foreach ($results as $result)
						$allValues[]=$result->id;
				}
				//None support
				$allValues[] = 0;
				//All support
				$allValues[] = ALL;
				break;
			default:
				XiPTLibraryUtils::XAssert(0, "Unknown build type was asked.");
		}
		
		if(!strcmp(strtolower($what),strtolower('profiletype')) || !strcmp(strtolower($what),strtolower('otherprofiletype')))
		{
			$html	= '<span>';
			
			$html	.= '<select  name="'.$what.'"  id="'.$what.'">';
			foreach($allValues as $vals)
			{	
				$selected	= ( trim($value) == $vals ) ? 'selected="true"' : '';
				$html		.= '<option value="' . $vals . '"' . $selected . '>' . XiPTHelperAclRules::getProfileTypeNameforAclRules($vals) . '</option>';
			}
			
			$html	.= '</span>';	
		}
		else
		{
			$html	= '<span>';
			$html	.= '<select  name="'.$what.'"  id="'.$what.'">';
			
			foreach($allValues as $key => $vals)
			{		
				$selected	= ( trim($value) == $key ) ? 'selected="true"' : '';
				$html		.= '<option value="' .$key . '"' . $selected . '>' 
							.ucfirst($vals) . '</option>';
			}
			
			$html	.= '</span>';	
		}
		return $html;
	}
	//difference in getProfileTypeName()  and getProfileTypeNameforAclRules is that in this we will return "NONE" if profiletype is 0
	function getProfileTypeNameforAclRules($id)
	{
		if($id==0 || empty($id))
			return "NONE";

		if($id == ALL)
			return "ALL";
		
		return XiPTHelperProfiletypes::getProfileTypeName($id);
	}

function _getDisplayNameofAclFeature($feature ="")
	{
		//TODO : Centralized these feature list to one place. in helper.
		$allValues['aclFeatureJoinGroup'] 		= "Join Group";
		$allValues['aclFeatureCreateGroup'] 	= "Create Group";				
		$allValues['aclFeatureAddPhotos'] 		= "Add Photos";
		$allValues['aclFeatureAddAlbum'] 		= "Add Album";				
		$allValues['aclFeatureAddVideos'] 		= "Add Videos";
		$allValues['aclFeatureWriteMessages'] 	= "Write Messages";
		$allValues['aclFeatureChangeAvatar'] 	= "Can't Change Avatar";
		$allValues['aclFeatureChangePrivacy'] 	= "Can't Change Privacy";
		$allValues['aclFeatureEditProfile'] 	= "Can't Edit Self Profile";
		$allValues['aclFeatureEditProfileDetail'] 	= "Can't Edit Self Profile Details";
		$allValues['aclFeatureCantVisitOtherProfile'] 	= "Can't View Others Profile";

		if (!$feature)
			return $allValues;
			
		if(array_key_exists($feature,$allValues))
				return ($allValues[$feature]);

		XiPTLibraryUtils::XAssert(0, "Unknown aclFeature was asked.");
		return false;	
	}
	
	function isFriend($userId, $viewUserId)
	{
		$db 		= & JFactory::getDBO();
		$query		= 'SELECT '. $db->nameQuote('connection_id').'  FROM ' . $db->nameQuote( '#__community_connection')
								.' WHERE '. $db->nameQuote('connect_from').'='.$db->Quote($userId)
								.' AND '. $db->nameQuote('connect_to').'='.$db->Quote($viewUserId)
								.' AND '. $db->nameQuote('status').'='.$db->Quote('1');
		$db->setQuery( $query );
		return $db->loadResult();		
	}
}
