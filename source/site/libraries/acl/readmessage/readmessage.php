<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class readmessage extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		return true;
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option'] && 'inbox' == $data['view'] )
		    	if($data['task'] === 'read')
			return true;
			
		return false;
	}
}