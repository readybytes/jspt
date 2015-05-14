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
		
		$pagination	 = $profiletype->getPagination();
		$fields		 = $profiletype->loadRecords($pagination->limit, $pagination->limitstart);

		$profiletypes = array();
		$allTypes = XiptLibProfiletypes::getProfiletypeArray();
		$this->setToolbar();
		
		// In backend, always show avatar from JSPT Default path
		foreach($fields as $field)
		{
			$avatar = JFile::getName($field->avatar);
			$field->avatar = PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.$avatar;
		}

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
		$privacyParams	 = $model->loadParams($id,XIPT_PRIVACY);
		
		// cover-image stuff loaded here
		$coerImage	 = $model->loadParams($id,'coverimage');
		
		// In backend, always show avatar from JSPT Default path
		foreach($records as $record)
		{
			$avatar = JFile::getName($record->avatar);
			$record->avatar = PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.$avatar;
		}
		
		$this->assignRef('coverImage', $coerImage);
		$this->assignRef('watermarkParams', $watermarkParams);
		$this->assignRef('configParams', 	$configParams);
		$this->assignRef('privacyParams', 	$privacyParams);
		$this->assign('data', $records[$id]);
			
		$this->setToolbar('edit');

		return parent::display($tpl);
	}
	
	function setToolbar($task='display')
	{
		$task = JRequest::getVar('task',$task);

		JToolBarHelper::title( XiptText::_( 'PROFILETYPES' ), 'profiletypes' );
//		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();
		
		
		if($task === 'edit'){
			JToolBarHelper::apply('apply', 'COM_XIPT_APPLY');
			JToolBarHelper::save('save','COM_XIPT_SAVE');
			JToolBarHelper::cancel( 'cancel', 'COM_XIPT_CLOSE');			
			return true;
		}	
		
		//default
		JToolBarHelper::publishList('switchOnpublished', 'COM_XIPT_PUBLISH' );
		JToolBarHelper::unpublishList('switchOffpublished', 'COM_XIPT_UNPUBLISH' );
		JToolBarHelper::divider();
		JToolBarHelper::custom('copy','copy','','COM_XIPT_COPY',0,0);
		JToolBarHelper::trash('remove', 'COM_XIPT_DELETE' );
		JToolBarHelper::addNew('edit', 'COM_XIPT_ADD_PROFILETYPES');
		return true;
	}
	
	function resetall($id, $start, $total= 0, $limit, $tpl = 'resetall'){
		$this->assignRef('id', $id);
		$this->assignRef('start', $start);
		$this->assignRef('limit', $limit);
		$this->assignRef('total', $total);
		parent::display($tpl);
	}
	
	//get total no of users as per profiletype	 	
	public function getTotalUsers( $pid )
	{
		$query = new XiptQuery();
    	
    	return $query->select('count(1)')
    				 ->from('#__xipt_users')
    				 ->where("`profiletype` = $pid")
    				 ->dbLoadQuery("","")
    				 ->loadResult();
	}
	
	function getHtml($params, $name = null)
	{
		$profiletype = $this->getModel();
		
		return $profiletype->getParamHtml($params, $name);
	}
}