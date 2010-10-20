<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addprofilevideo extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		return true;
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option']
		    	&& 'profile' == $data['view']
		    	&& $data['task'] == 'ajaxlinkprofilevideo')
			return true;

		return false;
	}
}

