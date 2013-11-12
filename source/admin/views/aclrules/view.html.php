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

		$pagination	= $aclModel->getPagination();
		$rules		= $aclModel->loadRecords($pagination->limit, $pagination->limitstart);
		

		$this->setToolbar();

		$ruleProfiletype = array();
		$rulePlan        = array();
		if(!empty($rules)) {
			foreach($rules as $rule) {
				$aclObject = XiptAclFactory::getAclObject($rule->aclname);
				$aclObject->bind($rule);
				
				$restrict_by = $aclObject->getCoreParams('restrict_by',0);
				
				if($restrict_by){
					$plans 	     = $aclObject->getCoreParams('core_plan',0);
					$ptypes 	 = -1;
				}
				else{
					$plans 	     = -1;
					$ptypes 	 = $aclObject->getCoreParams('core_profiletype',0);
				}
				
				$ptypes = is_array($ptypes) ? $ptypes : array($ptypes);
				$plans  = is_array($plans) ? $plans : array($plans);
				
				foreach($ptypes as $ptype){
					$ruleProfiletype[$rule->id][] = XiptHelperProfiletypes::getProfiletypeName($ptype,true);
				}
				
				foreach($plans as $plan){
					
					if($plan == XIPT_PLAN_ALL || empty($plan))
						$rulePlan[$rule->id][] = XiptText::_("ALL");
					elseif($plan == XIPT_PROFILETYPE_NONE)
						$rulePlan[$rule->id][] = XiptText::_("NONE");
					else{
						if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_payplans')){
							$rulePlan[$rule->id][] = XiptText::_("NONE");
  							JFactory::getApplication()->enqueueMessage(XiptText::_("PAYPLANS_DOES_NOT_EXISTS"),'WARNING');
						}
  						else{
							$planInstance = PayplansApi::getPlan($plan);
							
							if($planInstance)
								$rulePlan[$rule->id][] = $planInstance->getTitle();
							else
								$rulePlan[$rule->id][] = XiptText::_("NONE");
  						}
					}
				}
				
				$ruleProfiletype[$rule->id] = implode(',', $ruleProfiletype[$rule->id]);
				$rulePlan[$rule->id] 		= implode(',', $rulePlan[$rule->id]);
			}
		}

		$this->assign( 'rules' , $rules );
		$this->assign( 'ruleProfiletype' , $ruleProfiletype );
		$this->assign( 'rulePlan' 		 , $rulePlan );
		$this->assignRef( 'pagination'	 , $pagination );
		return parent::display( $tpl );
    }

	function setToolBar($task='display')
	{
		// Set the titlebar text
		JToolBarHelper::title( XiptText::_( 'ACCESS_CONTROL' ), 'aclrules' );

		// Add the necessary buttons
//		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();

		if($task === 'edit'){
			JToolBarHelper::apply('apply', 'COM_XIPT_APPLY');
			JToolBarHelper::save('save','COM_XIPT_SAVE');
			JToolBarHelper::cancel( 'cancel', 'COM_XIPT_CLOSE' );
			return;
		}

		if($task === 'add'){
			JToolBarHelper::cancel( 'cancel', 'COM_XIPT_CLOSE' );
			return;
		}

		JToolBarHelper::addNew('add', 'COM_XIPT_ADD_ACL_RULES');
		JToolBarHelper::custom('copy','copy','','COM_XIPT_COPY',0,0);
		JToolBarHelper::trash('remove', 'COM_XIPT_DELETE' );
		JToolBarHelper::divider();
		JToolBarHelper::publishList('switchOnpublished', 'COM_XIPT_PUBLISH' );
		JToolBarHelper::unpublishList('switchOffpublished', 'COM_XIPT_UNPUBLISH' );
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
		$helpMsg = XiptAclHelper::getHelpMessage($data['aclname']);
		$this->assign('helpMsg', $helpMsg);
		$this->assign('coreParamsHtml',	$aclObject->getCoreParamsHtml());
		$this->assign('aclParamsHtml',	$aclObject->getAclParamsHtml());
		$this->assign('aclruleInfo',$data);

		$this->setToolbar($tpl);
		return parent::display($tpl);
	}
}
?>