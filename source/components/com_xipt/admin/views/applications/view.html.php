<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

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
	
	function edit($id,$tpl = null)
	{
		$this->assign( 'applicationId' , $id );
		
		// Set the titlebar text
		
		JToolBarHelper::title( JText::_( 'EDIT APPLICATIONS' ), 'applications' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=applications');
		JToolBarHelper::divider();
		JToolBarHelper::save('save',JText::_('SAVE'));
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
		parent::display($tpl);
	}
	
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'APPLICATIONS' ), 'applications' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
	}
}
