<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptViewProfileFields extends XiptView
{
    function display($tpl = null)
    {
		//define all categories
		$categories	= XiptHelperProfilefields::getProfileFieldCategories();

		$fields		= XiptLibJomsocial::getFieldObject();
		$this->setToolbar();

		$this->assign('fields', $fields);
		$this->assignRef('categories', $categories);
		return parent::display($tpl);
    }

	function edit($fieldId, $tpl = null)
	{
		$field		= XiptLibJomsocial::getFieldObject($fieldId);
		$this->assign('fields', $field);
		$categories	= XiptHelperProfilefields::getProfileFieldCategories();
		$this->assignRef('categories', $categories);
		$this->assign('fieldid', $fieldId);
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'EDIT FIELD' ), 'profilefields' );

		$pane	=& JPane::getInstance('sliders');
		$this->assignRef( 'pane'		, $pane );

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
