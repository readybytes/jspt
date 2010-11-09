<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiptViewProfiletypes extends XiptView 
{
    function display($tpl = null)
    {
    	$profiletype = $this->getModel();
		
		$fields		 = $profiletype->loadRecords();
		$pagination	 = $profiletype->getPagination();

		$profiletypes = array();
		$allTypes = XiptLibProfiletypes::getProfiletypeArray();
		$this->setToolbar();
		
		$this->assignRef( 'fields' 		, $fields );
		$this->assignRef( 'pagination'	, $pagination );
		return parent::display( $tpl );
    }
	
	function edit($id=0,$tpl = 'edit' )
	{
		$model = $this->getModel();
		$records = $model->loadRecords(null,null);

		if(isset($records[$id])===false)
			$records = $model->getEmptyRecord();
		
		$watermarkParams = $model->loadParams($id,'watermarkparams');
		$configParams	 = $model->loadParams($id,'config');
		$privacyParams	 = $model->loadParams($id,'privacy');
				
		$this->assignRef('watermarkParams', $watermarkParams);
		$this->assignRef('configParams', 	$configParams);
		$this->assignRef('privacyParams', 	$privacyParams);
		$this->assign('data', $records[$id]);
			
		$this->setToolbar('edit');
			
		$pane = JPane::getInstance('sliders', array('allowAllClose' => true));
		$this->assignRef('pane', $pane);

		return parent::display($tpl);
	}
	
	function setToolbar($task='display')
	{
		$task = JRequest::getVar('task',$task);

		JToolBarHelper::title( XiptText::_( 'PROFILETYPES' ), 'profiletypes' );
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();
		
		
		if($task === 'edit'){
			JToolBarHelper::apply('apply', XiptText::_('APPLY'));
			JToolBarHelper::save('save',XiptText::_('SAVE'));
			JToolBarHelper::cancel( 'cancel', XiptText::_('CLOSE' ));			
			return true;
		}	
		
		//default
		JToolBarHelper::publishList('switchOnpublished', XiptText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('switchOffpublished', XiptText::_( 'UNPUBLISH' ));
		JToolBarHelper::divider();
		JToolBarHelper::custom('copy','copy','',XiptText::_('COPY'),0,0);
		JToolBarHelper::trash('remove', XiptText::_( 'DELETE' ));
		JToolBarHelper::addNew('edit', XiptText::_( 'ADD PROFILETYPES' ));
		return true;
	}
}
