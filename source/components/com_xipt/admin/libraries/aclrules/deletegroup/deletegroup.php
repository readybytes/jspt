<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class deletegroup extends xiptAclRules
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
		/*XITODO : we will expect that vie task and should be given
		 * and from parsing we will find out that is this request for me
		 */ 
		if('com_community' == $data['option'] 
		    	&& 'groups' == $data['view'] 
		    	&& $data['task'] == 'ajaxdeletegroup') 
			return true;
			
		return false;
	}
	
	
}
