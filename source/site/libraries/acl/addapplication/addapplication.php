<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addapplication extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		return true;
	}

	function aclAjaxBlock($msg)
	{
		$objResponse   	= new JAXResponse();
		$title		= JText::_('CC PROFILE VIDEO');
		$objResponse->addScriptCall('cWindowShow', '', $title, 430, 80);
		return parent::aclAjaxBlock($msg, $objResponse);
	}  
	  
	function checkAclApplicable(&$data)
	{
		if('com_community' == $data['option'] && 'apps' == $data['view']
		    	&& ($data['task'] == 'ajaxadd' || $data['task'] == 'ajaxaddapp'))
			return true;

		return false;
	}


}
