<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addapplication extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	  
	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option'] && 'apps' == $data['view']
		    	&& ($data['task'] == 'ajaxadd' || $data['task'] == 'ajaxaddapp'))
			return true;

		return false;
	}
}
