<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'xiptcore.php' );
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
	
	function edit($id)
	{
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'AclRules' , 'XiPTTable' );
		$row->load( $id );	
		
		$this->assign( 'row' , $row );
		
		// Set the titlebar text
		
		JToolBarHelper::title( JText::_( 'Edit Jspt Rules' ), 'XiPTs' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=AclRules');
		JToolBarHelper::divider();
		JToolBarHelper::save('save','Save');
		JToolBarHelper::cancel( 'cancel', 'close' );
		//JToolBarHelper::
		
		parent::display($tpl);
		
	}
	
	
function _buildRadio($status, $fieldname, $values){
		$html	= '<span>';
		
		if($status || $status == '1'){
			$html	.= '<input type="radio" name="' . $fieldname . '" value="1" checked="checked" />' . $values[0];
			$html	.= '<input type="radio" name="' . $fieldname . '" value="0" />' . $values[1];
		} else {
			$html	.= '<input type="radio" name="' . $fieldname . '" value="1" />' . $values[0];
			$html	.= '<input type="radio" name="' . $fieldname . '" value="0" checked="checked" />' . $values[1];	
		}
		$html	.= '</span>';
		
		return $html;
	}
	
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Jspt Acl' ), 'AclRules' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'Publish' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'Unpublish' ));
		JToolBarHelper::divider();
		JToolBarHelper::trash('remove', JText::_( 'Delete' ));
		JToolBarHelper::addNew('edit', JText::_( 'Add Acl Rules' ));
	}
}
?>