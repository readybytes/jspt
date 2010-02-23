<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class editselfprofiledetails extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{
		/* we will return true b'coz it's not any requirenment
		 * to check count ,  if user is accessing url means 
		 * he is violating rule
		 * so we will send true 
		 * b'coz rule is applicable , we have already checked
		 */
		return true;
	}
	
	
	function checkAclAccesibility($data)
	{
		/*XITODO : we will expect that vie task and should be given
		 * and from parsing we will find out that is this request for me
		 */ 
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('profile' != $data['view'])
			return false;
			
		if($data['task'] == 'editdetails')
				return true;
				
		return false;
	}
	
}
