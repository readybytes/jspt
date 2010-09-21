<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class changeprivacy extends xiptAclRules
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
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('profile' != $data['view'])
			return false;
			
		if($data['task'] == 'privacy')
				return true;
				
		return false;
	}
	
}
