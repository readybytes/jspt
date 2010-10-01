<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptModelSettings extends XiptModel
{	
	function getParams($refresh = false)
	{		
		if(isset($this->_params) && $refresh === false)
			return $this->_params;
			
		$row   = $this->loadRecords();
		
		$settingsxmlpath = XIPT_FRONT_PATH_ASSETS.DS.'xml'.DS.'settings.xml';
		$settingsini     = XIPT_FRONT_PATH_ASSETS.DS.'ini'.DS.'settings.ini';
		$settingsdata    = JFile::read($settingsini);
		
		if(!JFile::exists($settingsxmlpath)){
			XiptError::raiseError(500,XiptText::_("SETTINGS.XML FILE NOT FOUND"));
			return false;
		}

		$this->_params = new JParameter($settingsdata,$settingsxmlpath);				
		$this->_params->bind($row['settings']->params);
		return $this->_params;
	}
}