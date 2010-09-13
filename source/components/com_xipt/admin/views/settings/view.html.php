<?php
/**
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

class XiPTViewSettings extends JView 
{
    
	function display($tpl = null)
	{
		$sModel 		 = XiFactory :: getModel('settings');
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
	