<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiptControllerSettings extends XiptController 
{	
	function save($post=null)
	{
		if($post===null)
			$post	= JRequest::get('post',JREQUEST_ALLOWRAW);		
					
		
		if(!$this->getModel()->saveParams($post['settings'],'settings','params')){ 	
			XiptError::raiseWarning(100 , XiptText::_('ERROR IN SAVING SETTINGS'));
			return false;		
		}
		
		$msg = XiptText::_('SETTINGS SAVED');
		$this->setRedirect("index.php?option=com_xipt&view=settings",$msg);
		return true;		
	}
}
