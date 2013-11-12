<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

class XiptControllerUsers extends XiptController 
{
	function edit($id=0, $acl=0)
	{
		$id = JRequest::getVar('id', $id);

		XiptError::assert($id, XiptText::_("USER_NOT_FOUND $id "), XiptError::ERROR);
		
		return $this->getView()->edit($id);
	}
	
	function search()
	{
		// Display the view
		return $this->getView()->search();
	}
	
	function _processSave($id=0, $post=null)
	{
		$info['id'] = $id = JRequest::getVar('id', $id);
		
		if($post === null)
			$post	= JRequest::get('post');
		
		$oldTemplate	= XiptLibProfiletypes::getUserData($id, 'TEMPLATE');
		
		$ptype			= $post['profiletypes'];
		$newTemplate 	= $post['template'];
		
		if($oldTemplate == $newTemplate) {
			$newTemplate = '';
		}
			
		$result		= XiptLibProfiletypes::updateUserProfiletypeData($id, $ptype, $newTemplate, $what='ALL');
		
		$info['msg'] = XiptText::_('USER_SAVED');
		if (!$result) {
			$info['msg'] = XiptText::_('ERROR_IN_SAVING_USER');
		}	

		return $info;
	}
	
	function save()
	{
		$data = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=users', false);		
		$this->setRedirect($link, $data['msg']);		
	}
	
	function apply()
	{
		$data = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=users&task=edit&id='.$data['id'], false);
		$this->setRedirect($link, $data['msg']);				
	}		
}