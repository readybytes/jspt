<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class ignoreuser extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('profile' == $data['view'] && ($data['task'] === strtolower('ajaxIgnoreUser') || $data['task'] === strtolower('ajaxConfirmIgnoreUser')))
				return true;

		if('activities' == $data['view'] && ( $data['task'] === strtolower('ajaxConfirmIgnoreUser') || $data['task'] === strtolower('ajaxIgnoreUser')))
			return true;

		return false;
	}
}

