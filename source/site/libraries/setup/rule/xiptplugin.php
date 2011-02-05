<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptSetupRuleXiptplugin extends XiptSetupBase
{
	function isRequired()
	{	
		return (!$this->_isPluginInstalledAndEnabled());
	}
	
	function doApply()
	{
		if(XiptHelperUtils::changePluginState('xipt_community', 1) == false
			|| XiptHelperUtils::changePluginState('xipt_system', 1) == false)
			return false;
			
		return XiptText::_("PLUGIN ENABLED SUCCESSFULLY");
	}
	
	function doRevert()
	{
		if(XiptHelperUtils::changePluginState('xipt_community', 0) == false
			|| XiptHelperUtils::changePluginState('xipt_system', 0) == false)
			return false;
			
		return true;
	}
	
	//retrun true if plugin is installed or enabled
	//type means plugin type eg :- community , system etc.
	function _isPluginInstalledAndEnabled()
	{
		$communityPlugin = XiptHelperUtils::getPluginStatus('xipt_community');
		if(!$communityPlugin || $communityPlugin->enabled == 0)
			return false;	
			
		$systemPlugin = XiptHelperUtils::getPluginStatus('xipt_system');
		if(!$systemPlugin || $systemPlugin->enabled == 0)
			return false;
			
		return true;
	}
	

	function getMessage()
	{
		$requiredSetup = array();
		if($this->isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=xiptplugin",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.XiptText::_("PLEASE CLICK HERE TO ENABLE PLUGIN").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = XiptText::_("PLUGINS ARE ENABLED");
			$requiredSetup['done']  = true;
		}
			
		return $requiredSetup;
	}
}