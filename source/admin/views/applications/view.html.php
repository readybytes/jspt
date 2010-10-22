<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptViewApplications extends XiptView 
{
	function display($tpl = null)
	{
		$aModel	= $this->getModel();
		
		$fields		= $aModel->getPlugin();
		$pagination	= $aModel->getPagination();
		
		$this->setToolbar();
		
		$this->assignRef( 'fields' 		, $fields );
		$this->assignRef( 'pagination'	, $pagination );
		parent::display( $tpl );
    }
	
	function edit($id,$tpl = 'edit')
	{
		$fields	= $this->getModel()->getPlugin();
		
		$this->assignRef( 'fields' 		, $fields );
		$this->assign( 'applicationId' , $id );
		$this->setToolbar();
		return parent::display($tpl);
	}
	
	// set the toolbar according to task	 	 
	function setToolbar($task='display')
	{	
		$task = JRequest::getVar('task',$task);
		if($task === 'display'){		
			JToolBarHelper::title( XiptText::_( 'APPLICATIONS' ), 'applications' );
			JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
			return true;
		}
		
		if($task === 'edit'){
			JToolBarHelper::title( XiptText::_( 'EDIT APPLICATIONS' ), 'applications' );
			JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=applications');
			JToolBarHelper::divider();
			JToolBarHelper::save('save',XiptText::_('SAVE'));
			JToolBarHelper::cancel( 'cancel', XiptText::_('CLOSE' ));
			return true;
		}		
	}
}
