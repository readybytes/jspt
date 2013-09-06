<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class aecredirect extends XiptAclBase
{
	function checkAclViolation($data)
	{

		$redirectUrl  	= XiptRoute::_($this->getRedirectUrl());
		$redirectURI 	= new JURI($redirectUrl);
		$redirectVar    = $redirectURI->getQuery(true);

		//when SEF is enabled, JURI didn't set query as there is no &amp in URL
		//in this case, we have to take URL without routing, so we can handle it
		if(empty($redirectVar)){
			$redirectUrl  	= $this->getRedirectUrl();
			$redirectURI 	= new JURI($redirectUrl);
			$redirectVar    = $redirectURI->getQuery(true);
		}
		
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

	function getResourceOwner($data)
	{
		return $data['userid'];	
	}

	function checkAclApplicable(&$data)
	{
		$aecExists 		  = XiptLibAec::isAecExists();
		$subs_integrate   = XiptFactory::getSettings('subscription_integrate',0);
		$integrate_with   = XiptFactory::getSettings('integrate_with',0);

		// pType already selected
		if(!$subs_integrate || $integrate_with != 'aec' || !$aecExists)
			return false;
			
		$user=JFactory::getUser();
		if(!$user->id)
			return false;

		if('com_acctexp' == $data['option'])
			return false;

		if ($data['option'] == 'com_user')
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