<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptViewAclRules extends XiptView 
{
	function display($tpl = null)
	{
		$aclModel	= $this->getModel();
		
		$rules		= $aclModel->loadRecords();
		$pagination	= $aclModel->getPagination();
		
		$this->setToolbar();

		$ruleProfiletype = array();
		if(!empty($rules)) {
			foreach($rules as $rule) {
				$aclObject = XiptAclFactory::getAclObject($rule->aclname);
				$aclObject->bind($rule);
				$ptype = $aclObject->getCoreParams('core_profiletype',0);
				$ruleProfiletype[$rule->id] = XiptHelperProfiletypes::getProfiletypeName($ptype,true);
			}
		}
		
		$this->assign( 'rules' , $rules );
		$this->assign( 'ruleProfiletype' , $ruleProfiletype );
		$this->assignRef( 'pagination'	, $pagination );
		return parent::display( $tpl );
    }
	
	function setToolBar()
	{		
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'ACCESS CONTROL' ), 'AclRules' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();
		JToolBarHelper::addNew('add', JText::_( 'ADD ACL RULES' ));
		JToolBarHelper::trash('remove', JText::_( 'DELETE' ));
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'UNPUBLISH' ));
	}

	function add($tpl = 'add')
	{
		$acl = XiptAclFactory::getAcl();
		$this->assign( 'acl' , $acl );
		return parent::display($tpl);
	}	
	
	function edit($data,$tpl = 'edit')
	{
		$coreParamsHtml = '';
		$aclParamsHtml = '';
		
		//call htmlrender fn
		$aclObject = XiptAclFactory::getAclObject($data['aclname']);
		
		$aclObject->bind($data);
		$aclObject->getHtml($coreParamsHtml,$aclParamsHtml);
		
		$this->assignRef('coreParamsHtml',		$coreParamsHtml);
		$this->assignRef('aclParamsHtml',		$aclParamsHtml);
		$this->assign('aclruleInfo',$data);
		return parent::display($tpl);
	}
}
