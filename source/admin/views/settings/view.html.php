<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiptViewSettings extends XiptView 
{
    
	function display($tpl = null)
	{
		$sModel 		 = XiptFactory :: getModel('settings');
		$settingsParams  = $sModel->getParams();
		
		$settingParamsHtml = $settingsParams->render('settings');	
		
		$this->assignRef('settingsParamsHtml',$settingParamsHtml);
		
		$lang =& JFactory::getLanguage();
		if($lang)
			$lang->load( 'com_community' );
		
		JToolBarHelper::title( JText::_( 'SETTINGS' ), 'settings' );
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();
		JToolBarHelper::save('save',JText::_('SAVE'));
		parent::display($tpl);
	}
	
}
	