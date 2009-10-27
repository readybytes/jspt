<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'xiptcore.php' );
class XiPTViewApplications extends JView 
{
	function display($tpl = null){
		$aModel	= XiFactory::getModel( 'Applications' );
		
		$fields		=& $aModel->getFields();
		$pagination	=& $aModel->getPagination();
		
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');
		
		$this->setToolbar();
		
		$this->assignRef( 'fields' 		, $fields );
		$this->assignRef( 'pagination'	, $pagination );
		parent::display( $tpl );
    }
	
	function edit($id)
	{
		$this->assign( 'applicationId' , $id );
		
		// Set the titlebar text
		
		JToolBarHelper::title( JText::_( 'Edit Applications' ), 'applications' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=Applications');
		JToolBarHelper::divider();
		JToolBarHelper::save('save','Save');
		JToolBarHelper::cancel( 'cancel', 'Close' );
		parent::display($tpl);
	}
	
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Applications' ), 'Applications' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
	}
}
?>