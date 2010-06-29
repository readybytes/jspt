<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class accessevent extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{	
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		$eventId	= JRequest::getVar( 'eventid' , '' , 'get' );
		$ownerid	= $this->getownerId($eventId);
		$otherpid	= XiPTLibraryProfiletypes::getUserData($ownerid,'PROFILETYPE');
		
		// XITODO : give friend support also
		
		if((0 != $otherptype)
			&& (-1 != $otherptype)
				 && ($otherpid != $otherptype))
			return false;
			
		return true;
	}
	
		
	function checkAclAccesibility(&$data)
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