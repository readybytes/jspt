<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class aecredirect extends xiptAclRules
{

	function __construct($debugMode)
	{
		jimport( 'joomla.filesystem.files' );
		$this->debugMode = $debugMode;
		$className		 = 'aecredirect';
		$this->aclname 	 = $className;
		$aclxmlpath =  dirname(__FILE__) . DS . $className .'.xml';
		if(!$this->aclparams && JFile::exists($aclxmlpath))
			$this->aclparams = new JParameter('',$aclxmlpath);
		else if(!$this->aclparams && !JFile::exists($aclxmlpath))
			$this->aclparams = new JParameter('','');

		$corexmlpath = dirname(__FILE__) . DS . 'coreparams.xml';
		if(JFile::exists($corexmlpath))
			$this->coreparams = new JParameter('',$corexmlpath);
			
		$this->id = 0;
		$this->rulename = '';
		$this->published = 1;
		
	}
	

	public function checkAclViolatingRule($data)
	{
			
		$currentURI  	= JURI::getInstance();
	
		$redirectUrl  	= XiPTRoute::_($this->getRedirectUrl());
		$redirectURI 	= new JURI($redirectUrl);
		
		$currVar     = $currentURI->getQuery(true);
		$redirectVar = $redirectURI->getQuery(true);
					
	
		foreach($redirectVar as $key=> $value)
		{
			if(array_key_exists($key, $currVar))
			{
				if($value !=  $currVar[$key])
					return true;
			}
		}
		
		return false;
	}
	
		
	function checkAclAccesibility(&$data)
	{	
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
	
}