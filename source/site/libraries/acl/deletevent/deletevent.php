<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class deletevent extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	
	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option']
		    	&& 'events' == $data['view']
		    	&& $data['task'] == 'ajaxdeleteevent')
			return true;

		return false;
	}

	function aclAjaxBlock($html, $objResponse=null)
	{
		//@JS4TODO
		$json['error']= '<h4>'.$html.'</h4><br />'.XiptText::_('YOU_ARE_NOT_ALLOWED_TO_PERFORM_THIS_ACTION');		
		$forcetoredirect =$this->getCoreParams('force_to_redirect','0');
		if($forcetoredirect)
		{
			$redirectUrl 	= JURI::base().'/'.$this->getRedirectUrl();
			$json['redirect']= $redirectUrl;
		}
		$json['btnDone']= XiptText::_('BACK');
		die( json_encode($json) );
		
	}
}
