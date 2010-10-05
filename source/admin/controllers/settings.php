<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiptControllerSettings extends XiptController 
{	
	function save($post=null)
	{
		if($post===null)
			$post	= JRequest::get('post',JREQUEST_ALLOWRAW);		
					
		$sModel	= XiptFactory::getInstance('settings', 'model');
		
		if(!$sModel->saveParams($post['settings'],'settings')){ 	
			XiptError::raiseWarning(100 , JText::_('ERROR IN SAVING SETTINGS'));
			return false;		
		}
		
		$msg = JText::_('SETTINGS SAVED');
		$this->setRedirect("index.php?option=com_xipt&view=settings",$msg);
		return true;		
	}		
}
