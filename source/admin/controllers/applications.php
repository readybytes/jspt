<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiptControllerApplications extends XiptController 
{
	function edit($id=0)
	{
		//XITODO : remove edit it
		$id = JRequest::getVar('editId', $id);					
		return $this->getView()->edit($id,'edit');				
	}
	
	function save($post=null)
	{
		if($post===null)
			$post	= JRequest::get('post');	
			
		$aid 	= isset($post['id'])? $post['id'] : 0;
		$pType0 = isset($post['profileTypes0'])? true : false;

		
		//remove all rows related to specific plugin id 
		// cleaning all data for storing new profiletype with application
		$this->getModel()->delete(array('applicationid'=> $post['id']));
		
		$allTypes		= XiptHelperProfiletypes::getProfileTypeArray();
		
		$msg = JText::_('APPLICATION SAVED');
		$link = XiptRoute::_('index.php?option=com_xipt&view=applications', false);
		$this->setRedirect($link,$msg);
				
		if($pType0)
			return true;
 	
		//there might be case that all types have been selected, then we need no storage
		$allSelected = true;
		foreach($allTypes as $type)
		{
			if($type && array_key_exists('profileTypes'.$type,$post) == false){
				$allSelected = false;
				break;
			}
		}
		
		//still all selected, return true
		if($allSelected)
			return true;
		
		foreach($allTypes as $type){
			if($type && array_key_exists('profileTypes'.$type,$post) == true)
				continue;
			
			if($this->getModel()->save(array('applicationid'=>$aid,'profiletype'=>$type))===false)
			  	return false;
		}
		
		return true;		
	}
}