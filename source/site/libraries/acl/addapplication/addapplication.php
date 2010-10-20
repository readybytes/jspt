<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addapplication extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		return true;
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option']
		    	&& 'apps' == $data['view']
		    	&& $data['task'] == 'ajaxadd')
			return true;

		return false;
	}


}
