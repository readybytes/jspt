<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class addalbums extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{
		$count = $this->getFeatureCounts($data['userid']);
		$maxmimunCount = $this->aclparams->get('addalbums_limit',0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	
	function getFeatureCounts($userid)
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT COUNT(*) '
			. ' FROM ' . $db->nameQuote( '#__community_photos_albums' )
			. ' WHERE '.$db->nameQuote('creator').'=' . $db->Quote( $userid );
		
		$db->setQuery( $query );
		return $db->loadResult();
	}
	
	
	function checkAclAccesibility($data)
	{
		/*XITODO : we will expect that view and task should be given
		 * and from parsing we will find out that is this request for me
		 */ 
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('photos' != $data['view'])
			return false;
			
		if('newalbum' != $data['task'])
			return false;
				
		return true;
	}
	
}
