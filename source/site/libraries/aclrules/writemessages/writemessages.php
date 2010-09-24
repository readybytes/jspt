<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class writemessages extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{	
		/* messagecountlimit = 2
		 * otherprofiletype -1 means none
		 * menas users can write PTYPE1 message to any profiletype user
		 * else if otherprofiletype is PTYPE1 means 
		 * particular profiletype user can 't write message
		 * to ptype PTYPE1 users more than 2
		 */
		
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		
		if((0 != $otherptype)
			&& (-1 != $otherptype)
				&& ($data['viewuserid'] == 0))
				return false;
		
		$otherpid	= XiPTLibraryProfiletypes::getUserData($data['viewuserid'],'PROFILETYPE');
		
		if((0 != $otherptype)
			&& (-1 != $otherptype)
				 && ($otherpid != $otherptype))
			return false;

		if($this->aclparams->get('acl_applicable_to_friend',1) == 0)
		{
			$isFriend = XiPTHelperAclRules::isFriend($data['userid'],$data['viewuserid']);
			if($isFriend)
			 return false;
		}
		
		$count = $this->getFeatureCounts($data,$otherptype);
		$maxmimunCount = $this->aclparams->get('writemessage_limit',0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	
	function getFeatureCounts($data,$otherptype)
	{
		CFactory::load( 'helpers' , 'time' );
		$db			=& JFactory::getDBO();
		
		/* otherptype o means rule is defined to count message written to any one */
		if($otherptype == -1 || $otherptype == 0) {
			$query	= 'SELECT COUNT(*) FROM ' . $db->nameQuote( '#__community_msg' ) . ' AS a'
					. ' WHERE a.from=' . $db->Quote( $data['userid'] )
					. ' AND a.parent=a.id';
		}
		else
		{
			$query = "SELECT COUNT(*) FROM #__community_msg_recepient as a "
					." 	LEFT JOIN #__community_msg as b ON b.`id` = a.`msg_id` "
					."  LEFT JOIN #__xipt_users as c ON a.`to`=c.`userid` "
					."  WHERE a.`msg_from` = ".$data['userid']
					."  AND c.`profiletype`='$otherptype'" ; 
		}

		$db->setQuery( $query );
		$count		= $db->loadResult();
		return $count;
	}
	
	function aclAjaxBlock($msg)
	{
		$objResponse   	= new JAXResponse();
		$title		= JText::_('CC WRITE MESSAGE');
		$objResponse->addScriptCall('cWindowShow', '', $title, 430, 80);
		return parent::aclAjaxBlock($msg, $objResponse);
	}  
	
	function checkAclAccesibility(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('inbox' != $data['view'])
			return false;
			
		if($data['task'] == 'ajaxcompose' || $data['task'] == 'ajaxaddreply' ) {
			//modify whom we are sending msg
			$data['viewuserid'] = $data['args'][0];
			return  true;
		}
		
		if($data['task'] == 'write') {
			$otherptype = $this->aclparams->get('other_profiletype',-1);
			if($otherptype == 0 || $otherptype == -1)
				return true;
		}
		
		if($data['task'] == 'write' && $data['viewuserid'] == 0) {
			$viewusername = JRequest::getVar('to','','POST');
			if($viewusername != '') {
				$db			=& JFactory::getDBO();
		
				$query = "SELECT * FROM ".$db->nameQuote('#__users')
						." WHERE ".$db->nameQuote('username')."=".$db->Quote($viewusername);
					
				$db->setQuery( $query );
				$user = $db->loadObject();
				
				if(!empty($user))
					$data['viewuserid'] = $user->id;
					
				return  true;
			}
				
			return  false;
		}
		
				
		return false;
	}
	
}
