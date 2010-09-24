<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
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
			
		$redirectUrl  	= XiPTRoute::_($this->getRedirectUrl());
		$redirectURI 	= new JURI($redirectUrl);
		$redirectVar = $redirectURI->getQuery(true);		
					
		foreach($redirectVar as $key=> $value)
		{
			if(array_key_exists($key, $data))
			{
				if($value !=  $data[$key])
					return true;
			}
		}
		
		return false;
	}
	
		
	function checkAclAccesibility(&$data)
	{
		$aecExists = XiPTLibraryAEC::_checkAECExistance();
		$integrateAEC   = XiPTLibraryUtils::getParams('aec_integrate',0);

		// pType already selected
		if(!$integrateAEC || !$aecExists)
			return false;
			
		$user=JFactory::getUser();
		if(!$user->id)
			return false;
			
		if ('com_user' == $data['option'])
			return false;

		if('com_acctexp' == $data['option'])// && 'atexp' != $data['option'])
			return false;
			
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			return false;
				
		return true;
	}
	
	public function getRedirectUrl()
	{
		$redirectUrl  = 'index.php?option=com_acctexp&task=subscribe';
		return $redirectUrl;
	}
	
}
