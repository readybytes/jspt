<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class deleteprofilevideo extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		return true;
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option']
		    	&& 'profile' == $data['view']
		    	&& $data['task'] == 'ajaxremovelinkprofilevideo')
			return true;

		return false;
	}


}

