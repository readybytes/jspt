<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class statusbox extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		return true;
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
