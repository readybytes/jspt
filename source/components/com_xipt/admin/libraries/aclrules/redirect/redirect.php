<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class redirect extends xiptAclRules
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
		$aecExists = XiPTLibraryAEC::_checkAECExistance();
		$integrateAEC   = XiPTLibraryUtils::getParams('aec_integrate','com_xipt',0);

		// pType already selected
		if(!$integrateAEC || !$aecExists)
			return false;
			
		$user=JFactory::getUser();
		if(!$user->id)
			return false;
			
		if('com_acctexp' == $data['option'])// && 'atexp' != $data['option'])
			return false;
			
		if($data['args'][0] != 0 && $data['task'] === 'ajaxconnect')
				return false;
				
		return true;
	}
	
}
