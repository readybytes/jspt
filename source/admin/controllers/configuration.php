<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiptControllerConfiguration extends XiptController 
{	
	function edit($id=0)
	{		
		$id 	= JRequest::getVar('editId', $id , 'GET');			
		$view	= $this->getView();
		return $view->edit($id);		
	}
	
	function save($id=0, $postData=null)
	{
		$id	= JRequest::getVar('id', $id, 'post');
		if($postData === null)
			$postData	= JRequest::get('post', JREQUEST_ALLOWRAW );
			
		$pModel	= XiptFactory::getInstance('profiletypes', 'model');
		
		// Try to save configurations
		if(!$pModel->saveParams($postData, $id) ){
			XiptError::raiseWarning( 100 , JText::_( 'Unable to save configuration into database. Please ensure that the table jos_community_config exists' ) );
			return false;		
		}
			
		$link = XiptRoute::_('index.php?option=com_xipt&view=configuration', false);
		$msg	= JText::_('Configuration Updated');
		$this->setRedirect($link,$msg);
		return true;
	}
	
	function reset($id=0)
	{		
		$id		= JRequest::getVar( 'profileId',$id,'GET');

		$pModel	= XiptFactory::getModel( 'profiletypes' );
		
		// Try to save configurations
		if(!$pModel->save(array('params'=>''),$id)){
			XiptError::raiseWarning( 100 , JText::_( 'Unable to reset profiletype into database. Please ensure that the table jos_xipt_profiletypes exists' ) );
			return false;
		}

		$link 	= XiptRoute::_('index.php?option=com_xipt&view=configuration', false);
		$msg 	= JText::_('Profiletype has been Reset');
		$this->setRedirect($link,$msg);
		return true;		
	}
}