<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profilefields.php' );
class XiPTViewProfileFields extends JView 
{
    function display($tpl = null){
		$fields = XiPTHelperProfileFields::get_jomsocial_profile_fields();
		
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');
		
		$this->assign('fields', $fields);
		return parent::display($tpl);
    }
	
	function edit($fieldId)
	{
		$this->assign('fieldid', $fieldId);
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Edit Field' ), 'profilefields' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=profilefields');
		JToolBarHelper::divider();
		//JToolBarHelper::trash('save', JText::_( 'Save' ));
		JToolBarHelper::save('save','Save');
		JToolBarHelper::cancel( 'cancel', 'Close' );
		parent::display($tpl);
	}
	
	/**
	 * Private method to set the toolbar for this view
	 * 
	 * @access private
	 * 
	 * @return null
	 **/	 	 
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Profile Fields' ), 'profilefields' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
	}

}
?>