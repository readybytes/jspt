<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiPTViewAclRules extends JView 
{
	function display($tpl = null){
		$jaclModel	= XiFactory::getModel( 'AclRules' );
		
		$fields		=& $jaclModel->getFields();
		$pagination	=& $jaclModel->getPagination();
		
		$this->setToolbar();
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');

		$this->assignRef( 'fields' 		, $fields );
		$this->assignRef( 'pagination'	, $pagination );
		parent::display( $tpl );
    }
	
	function edit($id, $tpl = null)
	{
		$row	=& JTable::getInstance( 'AclRules' , 'XiPTTable' );
		$row->load( $id );	
		
		$this->assign( 'row' , $row );
		
		// Set the titlebar text
		
		JToolBarHelper::title( JText::_( 'EDIT ACL RULES' ), 'aclrules' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=AclRules');
		JToolBarHelper::divider();
		JToolBarHelper::save('save',JText::_('SAVE'));
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
		//JToolBarHelper::
		
		parent::display($tpl);
		
	}
	
	
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'ACL RULES' ), 'AclRules' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'UNPUBLISH' ));
		JToolBarHelper::divider();
		JToolBarHelper::trash('remove', JText::_( 'DELETE' ));
		JToolBarHelper::addNew('edit', JText::_( 'ADD ACL RULES' ));
	}
}
