<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class statusbox extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	public function checkAclViolatingRule($data)
	{
		return true;
	}
	
	function checkAclAccesibility(&$data)
	{
		if('com_community' == $data['option'] 
		    	&& 'status' == $data['view'] 
		    	&& $data['task'] == 'ajaxupdate') 
			return true;
			
		return false;
	}
	
	
}
