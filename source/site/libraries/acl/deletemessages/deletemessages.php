<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class deletemessages extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['viewuserid'];	
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('inbox' != $data['view'])
			return false;

		if($data['task'] === 'ajaxremovefullmessages' || $data['task'] === 'ajaxdeletemessages')
				return true;

		return false;
	}
}