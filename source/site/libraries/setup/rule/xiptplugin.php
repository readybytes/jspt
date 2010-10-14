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
		$db		= JFactory::getDBO();
			
		$query	= ' UPDATE ' . $db->nameQuote( '#__plugins' )
				. ' SET '	 . $db->nameQuote('published').'='.$db->Quote('1')
	          	. ' WHERE '	 . $db->nameQuote('element').'='.$db->Quote('xipt_community')
	          	. ' OR '	 . $db->nameQuote('element').'='.$db->Quote('xipt_system');

		$db->setQuery($query);		
		if(!$db->query())
			return false;
			
		return JText::_("PLUGIN ENABLED SUCCESSFULLY");
	}
	
	function doRevert()
	{
		$db			= JFactory::getDBO();
			
		$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote('0')
	          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote('xipt_community')
	          	. ' OR '.$db->nameQuote('element').'='.$db->Quote('xipt_system');

		$db->setQuery($query);		
		return $db->query();
	}
	
	//retrun true if plugin is installed or enabled
	//type means plugin type eg :- community , system etc.
	function _isPluginInstalledAndEnabled()
	{
		$db		= JFactory::getDBO();
			
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__plugins' )
	         	 . ' WHERE '.$db->nameQuote('element').'='.$db->Quote('xipt_community')
	          	 . ' OR '.$db->nameQuote('element').'='.$db->Quote('xipt_system')
	          	 .' AND '.$db->nameQuote('published').'='.$db->Quote(1);

		$db->setQuery($query);		
		
		$plugin	= $db->loadObjectList();
		
		if(count($plugin)== 2)
			return true;
			
		return false;
	}
	

	function getMessage()
	{
		$requiredSetup = array();
		if($this->isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=xiptplugin",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO ENABLE PLUGIN").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = JText::_("PLUGINS ARE ENABLED");
			$requiredSetup['done']  = true;
		}
			
		return $requiredSetup;
	}
}