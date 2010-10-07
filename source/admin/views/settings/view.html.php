<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptViewSettings extends XiptView 
{
    
	function display($tpl = null)
	{
		$settingsParams  = $this->getModel()->getParams();		
		$settingParamsHtml = $settingsParams->render('settings');	
		
		$this->assignRef('settingsParamsHtml',$settingParamsHtml);	
		$this->setToolbar();
		parent::display($tpl);
	}
	
	function setToolBar()
	{
	 	JToolBarHelper::title( JText::_( 'SETTINGS' ), 'settings' );
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();
		JToolBarHelper::save('save',JText::_('SAVE'));
	}
}
	