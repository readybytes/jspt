<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class addvideos extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{
		$count = $this->getFeatureCounts($data['userid']);
		$maxmimunCount = $this->aclparams->get('addvideos_limit',0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	
	function getFeatureCounts($userid)
	{
		$db		=& JFactory::getDBO();
		$query  = "SELECT COUNT(*) FROM ".$db->nameQuote('#__community_videos')
					." WHERE ".$db->nameQuote('published')."=".$db->Quote('1')
					." AND ".$db->nameQuote('creator')."=".$db->Quote($userid)
					." AND ".$db->nameQuote('status')."=".$db->Quote('ready');
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
			
		if('videos' != $data['view'])
			return false;
			
		if($data['task'] == 'ajaxaddvideo' || $data['task'] == 'ajaxuploadvideo')
				return true;
				
		return false;
	}
	
}
