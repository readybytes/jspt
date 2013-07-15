<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class reportuser extends XiptAclBase
{
	function getResourceOwner($data)
	{
		$args	= $data['args'];
		return $args[2];	
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('system' != $data['view'])
			return false;

		if($data['task'] === 'ajaxreport')
				return true;

		return false;
	}
}