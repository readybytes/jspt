<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addasfriends extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['args'][0];	
	}
	
	function isApplicableOnMaxFeature($resourceAccesser,$resourceOwner, $data=null)
	{	
		$aclSelfPtype = $this->getACLAccesserProfileType();
		$otherPtype   = $this->getACLOwnerProfileType();
		
		$aclSelfPtype = is_array($aclSelfPtype) ? implode(',', $aclSelfPtype) : $aclSelfPtype;
		$otherPtype   = is_array($otherPtype)	? implode(',', $otherPtype)   : $otherPtype;
		
		$count = $this->getFeatureCounts($resourceAccesser,$resourceOwner,$otherPtype,$aclSelfPtype);
		$paramName = get_class($this).'_limit';
		$maxmimunCount = $this->aclparams->getValue($paramName,null,0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}

	function isApplicableOnMaxFeatureByPlan($resourceAccesser,$resourceOwner)
	{	
		$aclSelfPlan = $this->getACLAccesserPlan();
		$otherPlan   = $this->getACLOwnerPlan();
		
		$aclSelfPlan = is_array($aclSelfPlan) ? implode(',', $aclSelfPlan) : $aclSelfPlan;
		$otherPlan	 = is_array($otherPlan)	  ? implode(',', $otherPlan)   : $otherPlan;
		
		$count = $this->getFeatureCountsByPlan($resourceAccesser,$resourceOwner,$otherPlan,$aclSelfPlan);
		$paramName = get_class($this).'_limit';
		$maxmimunCount = $this->aclparams->getValue($paramName,null,0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	function getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype=null,$aclSelfPtype=null)
	{
	
		// XITODO : change this query into object
		$db		= JFactory::getDBO();
		$query	= 'SELECT DISTINCT(a.connect_to) AS id  FROM ' . $db->quoteName('#__community_connection') . ' AS a '
				. 'INNER JOIN ' . $db->quoteName( '#__users' ) . ' AS b '
				. 'ON a.connect_from=' . $db->Quote( $resourceAccesser ) . ' '
				. 'AND a.connect_to=b.id '
				. ' LEFT JOIN #__xipt_users as ptfrom ON a.`connect_to`=ptfrom.`userid`'
				. ' AND ptfrom .`profiletype` IN(' . $db->Quote($aclSelfPtype) .')'
				. ' INNER JOIN #__xipt_users as ptto ON a.`connect_to`=ptto.`userid`';
			//	. (  $otherptype ) ? 'AND ptto .`profiletype` IN(' . $db->Quote($otherptype) . ')' : '' ;
				
		$db->setQuery( $query );
		$count		= $db->loadColumn();
		return count($count); 
	}	
	
	function getFeatureCountsByPlan($resourceAccesser,$resourceOwner,$otherplan,$aclSelfPlan)
	{
		// XITODO : change this query into object
		$db		= JFactory::getDBO();
		$query	= 'SELECT DISTINCT(a.connect_to) AS id  FROM ' . $db->quoteName('#__community_connection') . ' AS a '
				. 'INNER JOIN ' . $db->quoteName( '#__users' ) . ' AS b '
				. 'ON a.connect_from=' . $db->Quote( $resourceAccesser ) . ' '
				. 'AND a.connect_to=b.id '
				. ' LEFT JOIN #__payplans_subscription as planfrom ON a.`connect_to`=planfrom.`user_id`'
				. ' AND planfrom .`plan_id` IN(' . $db->Quote($aclSelfPlan) .')'
				. ' INNER JOIN #__payplans_subscription as planto ON a.`connect_to`=planto.`user_id`';
			//	. ' AND planto .`plan_id` IN(' . $db->Quote($otherplan) . ')';
		$db->setQuery( $query );
		$count		= $db->loadColumn();
		return count($count);
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('friends' != $data['view'])
			return false;
			
		if($data['args'][0] != 0 && $data['task'] === 'ajaxconnect')
				return true;
				
		return false;
	}
}
