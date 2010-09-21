<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiPTControllerSettings extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
	{
		parent::display();
    }
	
	function save()
	{
		global $mainframe;
		$post	= JRequest::get('post');
		
		jimport('joomla.filesystem.file');

		$settingsTable	=& JTable::getInstance( 'settings' , 'XiPTTable' );
		$settingsTable->load('settings');
				
		$data = array();
		
		$registry	=& JRegistry::getInstance( 'xipt' );
		$registry->loadArray($post['settings'],'settings_params');
		// Get the complete INI string
		$data['params']	= $registry->toString('INI' , 'settings_params' );
		
		$data['name']='settings';
		unset($post['settings']);
				
		// Save it but delete first
		
		$settingsTable->bind($data);
		if($settingsTable->store())
			$data['msg'] = JText::_('ERROR IN SAVING SETTINGS');
		else
			$data['msg'] = JText::_('SETTINGS SAVED');	

		$mainframe->redirect("index.php?option=com_xipt&view=settings",$data['msg']);
		
	}		
}
