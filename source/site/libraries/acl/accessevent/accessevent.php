<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class accessevent extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		$eventId	= isset($data['eventid']) ? $data['eventid'] : 0;
		$eventId	= JRequest::getVar( 'eventid' , $eventId, 'REQUEST');
		$ownerid	= $this->getownerId($eventId);
		$otherpid	= XiptLibProfiletypes::getUserData($ownerid,'PROFILETYPE');

		if(!in_array($otherptype, array(XIPT_PROFILETYPE_ALL,XIPT_PROFILETYPE_NONE,$otherpid)))
			return false;

		if($this->aclparams->get('acl_applicable_to_friend',1) == 0)
		{
			$isFriend = XiptAclHelper::isFriend($data['userid'],$ownerid);
			if($isFriend) return false;
		}

		return true;
	}


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('events' != $data['view'])
			return false;

		if($data['task'] === 'viewevent')
				return true;

		return false;
	}

    function getownerId($id)
    {
		$db		=& JFactory::getDBO();
		$query	= 'SELECT `creator` '
				. ' FROM ' . $db->nameQuote( '#__community_events' )
				. ' WHERE '.$db->nameQuote('id').'=' . $db->Quote( $id );
		$db->setQuery( $query );
		return $db->loadResult();
    }

}