<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptSetupRuleCreateprofiletypes extends XiptSetupBase
{
	function isRequired()
	{
		$ptypes = XiptHelperProfiletypes::getProfileTypeArray();
		if($ptypes)
			return false;
			
		return true;
	}
	
	function doApply()
	{
		JFactory::getApplication()->redirect(XiptRoute::_("index.php?option=com_xipt&view=profiletypes&task=edit", false));
	}
	
	function getMessage()
	{
		$requiredSetup = array();
		
		if($this->isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=createprofiletypes",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO CREATE PROFILETYPES").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = JText::_("PROFILETYPE VALIDATION SUCCESSFULL");
			$requiredSetup['done'] = true;
		}
		
		return $requiredSetup;
	}
}