<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class addapplication extends XiptAclBase
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
		    	&& 'apps' == $data['view'] 
		    	&& $data['task'] == 'ajaxadd') 
			return true;
			
		return false;
	}
	
	
}
