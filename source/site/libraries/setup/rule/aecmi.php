<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptSetupRuleAecmi extends XiptSetupBase
{
	public static function isRequired()
	{	
		$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
		
		//check if file is present is not 
		if(!JFile::exists($miFilename))
			return true;
			
		 $sourceMIFilename = self::getMiFileName();
		$md5DestinationFile = md5(JFile::read($miFilename));
		$md5SourceFile = md5(JFile::read($sourceMIFilename));
		
		//check source and destination with md5
		if($md5DestinationFile != $md5SourceFile){
			JFile::delete($miFilename);
			return true;
		}

		return false;
	}
	
	public function doApply()
	{	
		
		$sourceMIFilename = self::getMiFileName();
		$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
		
		if(JFile::exists($miFilename))
			return XiptText::_('AEC_MI_ALREADY_EXIST');

		if(JFile::copy($sourceMIFilename , $miFilename))
			return XiptText::_('AEC_MI_COPIED_SUCCESSFULLY');
        
        return XiptText::_('AEC_MI_COPY_FAILED');
	}
	
	public function isApplicable()
	{
		return XiptLibAec::isAecExists();
	}
	
	public static function getMessage()
	{
		$requiredSetup = array();
		if(self::isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=aecmi",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.XiptText::_("PLEASE_CLICK_HERE_TO_INSTALL_JSPT_MI_INTO_AEC").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = XiptText::_("AEC_MI_ALREADY_THERE");
			$requiredSetup['done'] = true;
		}
			
		return $requiredSetup;
	}
	
	public static function getMiFileName()
	{
//		//get the verson of aec
//		$version = XiptLibAec::getVersion();
//
//		//if version is 0.14 something than change source file to mi_jomsocialjspt_14.php
//		if(stristr($version,'0.14'))
//			return JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'hacks'.DS.'mi_jomsocialjspt_14.php';
//
		return JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'hacks'.DS.'mi_jomsocialjspt.php';
	}
}
