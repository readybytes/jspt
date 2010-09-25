<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');


require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt' .DS. 'install' .DS. 'helper.php';

function com_install()
{	
	if(XiPTHelperInstall::check_version() == false)
		JError::raiseWarning('INSTERR', "XIPT Only support Jomsocial 1.8 or greater releases");
	
	if(XiPTHelperInstall::setup_database() == false)
		JError::raiseError('INSTERR', "Not able to setup JSPT database correctly");
		
	if(XiPTHelperInstall::copyAECfiles() == false)
		JError::raiseError('INSTERR', "Not able to replace MI files, Check permissions.");
	
	if(XiPTHelperInstall::installExtensions() == false){
		JError::raiseError('INSTERR', XiptText::_("NOT ABLE TO INSTALL EXTENSIONS"));
		return false;
	}	
	XiPTHelperInstall::show_instruction();
	
	XiPTHelperInstall::changePluginState('xipt_system',true);
	XiPTHelperInstall::changePluginState('xipt_community',true);
	return true;
}
