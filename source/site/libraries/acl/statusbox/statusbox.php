<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class statusbox extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option']
		    	&& 'status' == $data['view']
		    	&& $data['task'] == 'ajaxupdate')
			return true;

		return false;
	}


}
