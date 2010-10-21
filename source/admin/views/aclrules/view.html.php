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

	function setToolBar($task='display')
	{
		// Set the titlebar text
		JToolBarHelper::title( XiptText::_( 'ACCESS CONTROL' ), 'AclRules' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();

		if($task === 'edit'){
			JToolBarHelper::apply('apply', XiptText::_('APPLY'));
			JToolBarHelper::save('save',XiptText::_('SAVE'));
			JToolBarHelper::cancel( 'cancel', XiptText::_('CLOSE' ));
			return;
		}

		if($task === 'add'){
			JToolBarHelper::cancel( 'cancel', XiptText::_('CLOSE' ));
			return;
		}

		JToolBarHelper::addNew('add', XiptText::_( 'ADD ACL RULES' ));
		JToolBarHelper::trash('remove', XiptText::_( 'DELETE' ));
		JToolBarHelper::divider();
		JToolBarHelper::publishList('switchOnpublished', XiptText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('switchOffpublished', XiptText::_( 'UNPUBLISH' ));
	}

	function add($tpl = 'add')
	{
		$orderedAcl = XiptAclHelper::getOrderedRules();
				
		$this->assign('groups', $orderedAcl['groups']);
		$this->assign('rules', $orderedAcl['rules']);
		$this->setToolbar($tpl);
		return parent::display($tpl);
	}

	function edit($data,$tpl = 'edit')
	{
		//call htmlrender fn
		$aclObject = XiptAclFactory::getAclObject($data['aclname']);
		$aclObject->bind($data);

		$this->assignRef('coreParamsHtml',	$aclObject->getCoreParamsHtml());
		$this->assignRef('aclParamsHtml',	$aclObject->getAclParamsHtml());
		$this->assign('aclruleInfo',$data);

		$this->setToolbar($tpl);
		return parent::display($tpl);
	}
}
