<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addvideos extends XiptAclBase
{
	public function checkAclViolation($data)
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


	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('videos' != $data['view'])
			return false;

		if($data['task'] == 'ajaxaddvideo' || $data['task'] == 'ajaxuploadvideo')
				return true;

		return false;
	}

}
