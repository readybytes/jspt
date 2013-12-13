<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.application.component.view');
JHTML::_('behavior.tooltip', '.hasTip');

abstract class XiptView extends JViewLegacy
{	
	function display($tpl = null)
	{
		$css  		= JURI::root() . 'components/com_xipt/assets/admin.css';
		$document   = JFactory::getDocument();
		$document->addStyleSheet($css);
		
		// add sidebar sub menus
		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			$this->addSubmenu();
			$this->sidebar = JHtmlSidebar::render();
		}

		parent::display($tpl);
	}
	
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function addSubmenu()
	{
		$view = JFactory::getApplication()->input->get('view','cpanel');
		
		JHtmlSidebar::addEntry(
			'Home (Setup/Settings)',
			'index.php?option=com_xipt',
			false
		);
		
//		JHtmlSidebar::addEntry(
//			JText::_('COM_XIPT_SUBMENU_SETTINGS'),
//			'index.php?option=com_xipt&view=settings',
//			$view == 'settings'
//		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_XIPT_SUBMENU_PROFILETYPES'),
			'index.php?option=com_xipt&view=profiletypes',
			$view == 'profiletypes'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_XIPT_SUBMENU_PROFILEFIELDS'),
			'index.php?option=com_xipt&view=profilefields',
			$view == 'profilefields'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_XIPT_SUBMENU_CONFIGURATION'),
			'index.php?option=com_xipt&view=configuration',
			$view == 'configuration'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_XIPT_SUBMENU_JSTOOLBAR'),
			'index.php?option=com_xipt&view=jstoolbar',
			$view == 'jstoolbar'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_XIPT_SUBMENU_ACLRULES'),
			'index.php?option=com_xipt&view=aclrules',
			$view == 'aclrules'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_XIPT_SUBMENU_APPLICATIONS'),
			'index.php?option=com_xipt&view=applications',
			$view == 'applications'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_XIPT_SUBMENU_USERS'),
			'index.php?option=com_xipt&view=users',
			$view == 'users'
		);
		
		

	}
	
	/*
	 * Collect prefix auto-magically
	 */
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)View/i', get_class($this), $r)) {
			XiptError::raiseError (__CLASS__.'.'.__LINE__, "XiView::getPrefix() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}
	
	
	/*
	 * We need to override joomla behaviour as they differ in
	 * Model and Controller Naming	 
	 */
	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/View(.*)/i', get_class($this), $r)) {
				XiptError::raiseError (__CLASS__.'.'.__LINE__, "Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}
	
	/**
	 * Get an object of controller-corresponding Model.
	 * @return XiptModel
	 */
	public function getModel($modelName=null)
	{
		// support for parameter
		if($modelName===null)
			$modelName = $this->getName();

		return XiptFactory::getInstance($modelName,'Model');
	}
}
