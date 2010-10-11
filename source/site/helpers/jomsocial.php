<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperJomsocial
{
	function getTemplatesList()
	{	
		$path	= JPATH_ROOT. DS . 'components' . DS . 'com_community' . DS . 'templates';
		
		$handle = @opendir($path);
		if( $handle ){
			while(false !== ($file = readdir($handle))) {
				// Do not get '.' or '..' or '.svn' since we only want folders.
				if( $file != '.' && $file != '..' 
						&& $file != '.svn' && $file != 'index.html')
					$templates[]	= $file;
			}
		}
		return $templates;
	}
	
 	function getReturnURL()
    {
    	$regType = XiptFactory::getParams('user_reg');
        
        if($regType === 'jomsocial')
           return XiPTRoute::_('index.php?option=com_community&view=register', false);
         
        return XiPTRoute::_('index.php?option=com_user&view=register', false);
    }
}