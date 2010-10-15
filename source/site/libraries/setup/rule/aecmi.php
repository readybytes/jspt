<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptSetupRuleAecmi extends XiptSetupBase
{
	function isRequired()
	{
		$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
		if(JFile::exists($miFilename))
			return false;

		return true;
	}
	
	function doApply()
	{
		$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
		$sourceMIFilename = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'hacks'.DS.'mi_jomsocialjspt.php';

		if(JFile::exists($miFilename))
			return JText::_('AEC MI ALREADY EXIST');

		if(JFile::copy($sourceMIFilename , $miFilename))
			return JText::_('AEC MI COPIED SUCCESSFULLY');
        
        return JText::_('AEC MI COPY FAILED');
	}
	
	function isApplicable()
	{
		return XiptLibAec::isAecExists();
	}
	
	function getMessage()
	{
		$requiredSetup = array();
		if($this->isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=aecmi",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO INSTALL JSPT MI INTO AEC").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = JText::_("AEC MI ALREADY THERE");
			$requiredSetup['done'] = true;
		}
			
		return $requiredSetup;
	}
	
}