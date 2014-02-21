<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class writemessages extends XiptAclBase
{
	function getResourceOwner($data)
	{
		//get resource accessor
		$resourceAccesser = $this->getResourceAccesser($data);
		$resourceOwner	  = $data['viewuserid'];
		
		$resourceOwner		= is_array($resourceOwner)?$resourceOwner:array($resourceOwner);
		$resourceAccesser	= is_array($resourceAccesser)?$resourceAccesser:array($resourceAccesser);
		
		//Remove resource accessor from resource owner array
		//As a user can't msg himself
		$resourceOwner		= array_diff($resourceOwner,$resourceAccesser);
		
		return $resourceOwner;
	}
	
	function isApplicableOnMaxFeature($resourceAccesser,$resourceOwner, $data=NULL)
	{	
		$aclSelfPtype = $this->coreparams->getValue('core_profiletype',null,-1);
		$otherptype = $this->aclparams->getValue('other_profiletype',null,-1);
		
		$count = $this->getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype,$aclSelfPtype);
		$paramName ='writemessage_limit';
		$maxmimunCount = $this->aclparams->getValue($paramName,null,0);
		
		//In JS2.4++, user can msg to more than one user simlutaneously
		//$totalUsers = $data['count'];
		//$totalUsers = is_array($totalUsers)?$totalUsers:array($totalUsers);
		
		if(isset($data['count']))
			$userCount  = $data['count'];
		else
			$userCount  = 0;
		
		if($count >= $maxmimunCount || ($userCount+$count) > $maxmimunCount)
			return true;
			
		return false;
	}
	
	function getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype=null,$aclSelfPtype=null)
	{
		CFactory::load( 'helpers' , 'time' );
		$db			=& JFactory::getDBO();

		/* otherptype o means rule is defined to count message written to any one */
		if($otherptype == -1 || $otherptype == 0) {
			$query	= 'SELECT COUNT(*) FROM ' . $db->quoteName( '#__community_msg' ) . ' AS a'
					. ' WHERE a.from=' . $db->Quote( $resourceAccesser )
					. ' AND a.parent=a.id';
		}
		else
		{
			$query = "SELECT COUNT(*) FROM #__community_msg_recepient as a "
					." 	LEFT JOIN #__community_msg as b ON b.`id` = a.`msg_id` "
					."  LEFT JOIN #__xipt_users as c ON a.`to`=c.`userid` "
					."  WHERE a.`msg_from` = ".$resourceAccesser
					."  AND c.`profiletype`='$otherptype'" ;
		}

		$db->setQuery( $query );
		$count		= $db->loadResult();
		return $count;
	}

	function aclAjaxBlock($msg, $objResponse=null)
	{
		$objResponse   	= new JAXResponse();
		$title		= XiptText::_('CC_WRITE_MESSAGE');
		$objResponse->addScriptCall('cWindowShow', '', $title, 430, 80);
		return parent::aclAjaxBlock($msg, $objResponse);
	}

	function checkAclApplicable($data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('inbox' != $data['view'])
			return false;
		
		if($data['task'] == 'ajaxcompose') {
			//modify whom we are sending msg
			$data['viewuserid'] = $data['args'][0];
			
			return  true;
		}

		if($data['task'] == 'ajaxaddreply'){
			//modify whom we are sending msg
			// In Js2.4++, we get msg id in args instead of user id
			$msgId = $data['args'][0];
			$data['viewuserid'] = $this->getUserId($msgId);
			$data['count'] = 1;
			
			return  true;
		}

		if($data['task'] == 'write') {
			//if username give then find user-id
			$data['viewusername'] = isset($data['viewusername']) ? $data['viewusername']:  '';

			//In JS2.4.xx, user can send msg to many users at a time
			//And those user ids are set in "friends" variable
			$friendsId = JRequest::getVar('friends',array());
			
			if(!empty($friendsId)){
				$data['viewuserid'] = $friendsId;
			}
			
			//check if user is actually sending msg to someone
			if($data['viewuserid'])
				return  true;
				
			return false;
		}

		return false;
	}
	
	function checkAclViolation($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);

		//If user is replying to a message, then we don't need to count no. of users. 
		if(isset($data['count'])){
			$data['count'] = count($resourceOwner);
		}
		
		//if its not applicable on resource accessor, return false
		if($this->isApplicableOnSelfProfiletype($resourceAccesser) === false)
				return false;
				
		foreach($resourceOwner as $owner)
		{		
			//if its not applicable on currnet user, no need to check other condiotions
			if($this->isApplicableOnOtherProfiletype($owner) === false)
				continue;
							
			// if resource owner is friend of resource accesser 
			if($this->isApplicableOnFriend($resourceAccesser,$owner) === false)
				continue; 
			
			// if feature count is greater then limit
			if($this->isApplicableOnMaxFeature($resourceAccesser,$owner, $data) === false)
				continue;
				
			return true;
		}	
		return false;
	}
	
	function getUserId($msgId)
	{
		$userIds = array();
		$db	   = JFactory::getDBO();

		$query = "SELECT `msg_from`, `to` "
				." 	FROM #__community_msg_recepient "
				."  WHERE `msg_id` = ".$msgId;

		$db->setQuery( $query );
		$result	= $db->loadObjectList();
		
		$userIds[] = $result[0]->msg_from;
		$userIds[] = $result[0]->to;
		return $userIds;
	}
}
