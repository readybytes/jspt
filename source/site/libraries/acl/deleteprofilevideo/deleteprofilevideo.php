<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class deleteprofilevideo extends xiptAclRules
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
		    	&& 'profile' == $data['view'] 
		    	&& $data['task'] == 'ajaxremovelinkprofilevideo') 
			return true;
			
		return false;
	}
	
	
}

