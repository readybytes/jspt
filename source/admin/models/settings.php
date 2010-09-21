<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class XiPTModelSettings extends JModel
{
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		// Call the parents constructor
		parent::__construct();
	}	

	
	function getParams($reset = false)
	{
		static $settingsParams = null;
		if($settingsParams !== null && $reset === false)
			return $settingsParams;
			
		$row             =& JTable::getInstance( 'settings' , 'XiPTTable' );
		$row->load('settings');
		
		$settingspath    = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'settings';
		$settingsxmlpath = $settingspath.'.xml';
		$settingsini     = $settingspath.'.ini';
		$settingsdata    = JFile::read($settingsini);
		
		if(JFile::exists($settingsxmlpath))
			$settingsParams = new JParameter($settingsdata,$settingsxmlpath);
		else 
			$settingsParams = new JParameter('','');
		$settingsParams->bind($row->params);
		
		return $settingsParams;
		
	}
}