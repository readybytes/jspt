<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptModelSettings extends XiptModel
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
			
		$row   =& JTable::getInstance( 'settings' , 'XiptTable' );
		$row->load('settings');
		
		$settingsxmlpath = XIPT_FRONT_PATH_ASSETS.DS.'xml'.DS.'settings.xml';
		$settingsini     = XIPT_FRONT_PATH_ASSETS.DS.'ini'.DS.'settings.ini';
		$settingsdata    = JFile::read($settingsini);
		
		if(JFile::exists($settingsxmlpath))
			$settingsParams = new JParameter($settingsdata,$settingsxmlpath);
		else{ 
			$tmpParams = new JParameter('','');
			$tmpParams->bind($row->params);
			//raise warning
			return $tmpParams;
		}
		
		$settingsParams->bind($row->params);
		return $settingsParams;
	}
}