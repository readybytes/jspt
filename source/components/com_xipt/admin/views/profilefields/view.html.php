<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
class XiPTViewProfileFields extends JView 
{
    function display($tpl = null){
		$fields = XiPTHelperProfileFields::get_jomsocial_profile_fields();
		
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');
		$this->setToolbar();
		
		$this->assign('fields', $fields);
		return parent::display($tpl);
    }
	
	function edit($fieldId, $tpl = null)
	{
		$this->assign('fieldid', $fieldId);
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'EDIT FIELD' ), 'profilefields' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=profilefields');
		JToolBarHelper::divider();
		JToolBarHelper::save('save',JText::_('SAVE'));
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
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
		JToolBarHelper::title( JText::_( 'PROFILE FIELDS' ), 'profilefields' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
	}

}
?>