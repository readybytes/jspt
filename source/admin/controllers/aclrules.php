<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

class XiptControllerAclRules extends XiptController 
{
    function add()
	{				
		return $this->getView()->add();
	}
	
	
	function edit($id=0, $acl=0)
	{
		$id = JRequest::getVar('editId', $id);
		$acl = JRequest::getVar('acl', $acl) ;
		
		$view = $this->getView();

		XiptError::assert($acl || $id);
		
		if($acl)
			$aclObject = XiptAclFactory::getAclObject($acl);
		else
			$aclObject = XiptAclFactory::getAclObjectFromId($id);

		XiptError::assert($aclObject);
			
		$aclObject->load($id);

		$data = $aclObject->getObjectInfoArray();
		$data['id'] = $id;
		
		return $view->edit($data);
	}
	
	// XITODO :need test case
	function processSave($id=0, $post=null)
	{
		//save aclparam and core param in individual columns		
		$id 	 = JRequest::getVar('id', $id);
		$data 	 = array();
		if($post === null)	$post	= JRequest::get('post');
		
		$model 	= $this->getModel();		
		
		// Get the complete INI string of params
		$registry	= JRegistry::getInstance( 'xipt' );
		$registry->loadArray($post['coreparams'],'xipt_coreparams');
		$data['coreparams']	= $registry->toString('INI' , 'xipt_coreparams' );
		$data['aclname'] 	= $post['aclname'];
		$data['rulename']	= $post['rulename'];
		$data['published'] 	= $post['published'];
		
		$aclObject = XiptAclFactory::getAclObject($data['aclname']);
		$data['aclparams'] = $aclObject->collectParamsFromPost($post);
		
		// Save it // XITODO : clean it
		if(!($info['id'] = $model->save($data,$id)) )
			$info['msg'] = JText::_('ERROR IN SAVING RULE');
		else
			$info['msg'] = JText::_('RULE SAVED');	

		return $info;
	}
	
	function save()
	{
		$data = $this->processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=aclrules', false);		
		$this->setRedirect($link, $data['msg']);		
	}
	
	function apply()
	{
		$data = $this->processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=aclrules&task=edit&editId='.$data['id'], false);
		$this->setRedirect($link, $data['msg']);				
	}
	

	function remove($ids=array())
	{
		$ids	= JRequest::getVar('cid', $ids, 'post', 'array');
		$count	= count($ids);
		
		$i = 1;
		foreach( $ids as $id ){		
			if(!$this->getModel()->delete( $id )){
				// If there are any error when deleting, we just stop and redirect user with error.
				$message	= JText::_('ERROR IN REMOVING RULE');
				$this->setRedirect( 'index.php?option=com_xipt&view=aclrules' , $message);
				return false;
			}
			$i++;
		}
		
		$message	= $count.' '.JText::_('RULE REMOVED');		
		$link = XiptRoute::_('index.php?option=com_xipt&view=aclrules', false);
		$this->setRedirect($link, $message);
	}			
}
