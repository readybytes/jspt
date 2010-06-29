<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class createvent extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{
		$count = $this->getFeatureCounts($data['userid']);
		$maxmimunCount = $this->aclparams->get('createvent_limit',0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	
	function getFeatureCounts($userid)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT COUNT(*) FROM ' . $db->nameQuote( '#__community_events' ) . ' '
					. 'WHERE ' . $db->nameQuote( 'creator' ) . '=' . $db->Quote( $userid );
		
		$db->setQuery( $query );
		return $db->loadResult();
	}
	
	
	function checkAclAccesibility($data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('events' != $data['view'])
			return false;
			
		// XITODO : use pattern ( return false in below conditiion)
		if($data['task'] == 'create')
				return true;
				
		return false;
	}
	
}
