<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptSetupRuleWatermark extends XiptSetupBase
{
	function isRequired()
	{
		$ptypeArray	= XiptHelperProfiletypes::getProfileTypeArray();
		$globalWM	= XiptFactory::getParams('show_watermark',0);
		if($globalWM)
			return false;
		foreach($ptypeArray as $ptype)
		{
			$watermarkParams = XiptLibProfiletypes::getParams($ptype,'watermarkparams');
			if($watermarkParams == false)
				continue;
			if($watermarkParams->get('enableWaterMark',0) == true)
				return true;
		}
		
		return false;		
	}
	
	function getMessage()
	{
		if($this->isRequired())
			return JText::_("WATER MARKING IS NOT ENABLED IN SETTINGS BUT ENABLE FOR PROFILE TYPES.");		
	}
}