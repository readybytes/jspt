<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class cantviewotherprofile extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	

	public function checkAclViolatingRule($data)
	{	
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		$otherpid	= XiPTLibraryProfiletypes::getUserData($data['viewuserid'],'PROFILETYPE');
		
		if((0 != $otherptype)
			&& (-1 != $otherptype)
				 && ($otherpid != $otherptype))
			return false;
			
		return true;
	}
	
		
	function checkAclAccesibility(&$data)
	{
		/*XITODO : we will expect that vie task and should be given
		 * and from parsing we will find out that is this request for me
		 */ 
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('profile' != $data['view'])
			return false;
			
		if($data['viewuserid'] != 0 && $data['task'] === '')
				return true;
				
		return false;
	}
	
}